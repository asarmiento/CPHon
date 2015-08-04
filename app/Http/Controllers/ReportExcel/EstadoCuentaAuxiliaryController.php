<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 04/07/2015
 * Time: 11:00 PM
 */

namespace AccountHon\Http\Controllers\ReportExcel;


use AccountHon\Http\Controllers\ReportExcelController;
use Maatwebsite\Excel\Facades\Excel;

class EstadoCuentaAuxiliaryController extends ReportExcelController {

    public function estadoCuentaAuxiliary($token){
        $school = $this->schoolsRepository->whereId('id',userSchool()->id,'id');
        /** @var TYPE_NAME $catalog */
        $student = $this->studentRepository->token($token);
        $seatings= $this->auxiliarySeatRepository->whereDuo('financial_records_id',$student->financialRecords->id,'status','aplicado','id','ASC');
        $headers = array(
            array($school[0]->name),
            array('ESTADO DE CUENTA'),
            array($student->book.' '.$student->nameComplete()),
            array(''),
            array('Fecha','Descripción','Referencia','Debito','Credito')
        );
        $content = $headers;
        $countHeader = count($headers);
        foreach($seatings AS $seating):
            if($seating->types->name=='DEBITO'):
                $content[] = array($seating->date,$seating->detail,$seating->code,$seating->amount,'');
            else:
                $content[] = array($seating->date,$seating->detail,$seating->code,'',$seating->amount);
            endif;

        endforeach;
        $countContent = count($content);
        $content[] = array('','Fecha de Impresión: '.date('d-m-Y'),'Saldo ',$this->saldoEstadoCuentaAuxiliary($student));
        $countFooter = count($content);

        Excel::create(date('d-m-Y').'-'.$student->nameComplete(), function($excel) use ($student,$content,$countHeader,$countContent,$countFooter) {
            $excel->sheet($student->book, function($sheet)  use ($content,$countHeader,$countContent,$countFooter) {
                $sheet->mergeCells('A1:E1');
                $sheet->mergeCells('A2:E2');
                $sheet->mergeCells('A3:E3');
                $sheet->cell('A1', function($cell) {
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                });
                $sheet->cell('A2', function($cell) {
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                });
                $sheet->cell('A3', function($cell) {
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                });
                $sheet->cells('A5:E5', function($cells) {
                    $cells->setFontSize(12);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A'.$countFooter.':E'.$countFooter, function($cells) {
                    $cells->setFontSize(12);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                $sheet->fromArray($content, null, 'A1', true,false);
            });
        })->export('xlsx');

    }
    /**
     * @param $catalog
     * @return mixed
     */
    private function saldoEstadoCuentaAuxiliary($student){

        $debito = $this->nameType('DEBITO');
        $credito = $this->nameType('CREDITO');
        $seatingsDebito= $this->auxiliarySeatRepository->getModel()
            ->where('financial_records_id',$student->financialRecords->id)
            ->where('type_id',$debito->id)
            ->where('status','aplicado')
            ->sum('amount');

        $seatingsCredito= $this->auxiliarySeatRepository->getModel()
            ->where('financial_records_id',$student->financialRecords->id)
            ->where('type_id',$credito->id)
            ->where('status','aplicado')
            ->sum('amount');

        $total = $seatingsDebito-$seatingsCredito;

        return $total;
    }
}