<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 05/07/2015
 * Time: 03:38 AM
 */

namespace AccountHon\Http\Controllers\ReportExcel;


use AccountHon\Http\Controllers\ReportExcelController;
use Maatwebsite\Excel\Facades\Excel;

class AuxiliarySeatings extends ReportExcelController {


    public function index($token){

        $seatings= $this->auxiliarySeatRepository->whereDuo('token',$token,'status','aplicado','id','ASC');

        $headers = array(
            array(userSchool()->name),
            array('DETALLE DE ASIENTO'),
            array('Numero de Referencia: '.$seatings[0]->code),
            array('Fecha Asiento: '.$seatings[0]->date.'  PERIODO: '.$seatings[0]->accountingPeriods->period()),
            array(''),
            array('Código','Cuenta','Debito','Credito'),
            array('Descripción')
        );
        $content = $headers;
        $countHeader = count($headers);
        $debito = 0;
        $credito=0;
        foreach($seatings AS $seating):
            if($seating->types->name=='DEBITO'):
                $debito += $seating->amount;
               // $credito +=  $seating->amount;
                $content[] = array($seating->financialRecords->students->book,$seating->financialRecords->students->nameComplete(),$seating->amount,'');
                $content[] = array($seating->detail);
            else:
              //  $debito += $seating->amount;
                $credito +=  $seating->amount;
                $content[] = array($seating->financialRecords->students->book,$seating->financialRecords->students->nameComplete(),'',$seating->amount);
                $content[] = array($seating->detail);
            endif;


        endforeach;


            $controlDebito = $debito;
            $content[] = array('00-00000','Control Alumno',$credito,$debito);
            $content[] = array($seating->detail);
            $controlCredito = $credito;

        $controlCredito = $controlCredito + $debito ;
        $controlDebito = $controlDebito + $credito;
        $countContent = count($content);
        $content[] = array('Fecha de Impresión: '.date('d-m-Y'),'Total de Asiento ',$controlDebito,$controlCredito);
        $countFooter = count($content);
        Excel::create(date('d-m-Y').'-'.$seatings[0]->code, function($excel) use ($seatings,$content,$countHeader,$countContent,$countFooter) {
            $excel->sheet($seatings[0]->code, function($sheet)  use ($content,$countHeader,$countContent,$countFooter) {
                $sheet->mergeCells('A1:D1');
                $sheet->mergeCells('A2:D2');
                $sheet->mergeCells('A3:D3');
                $sheet->mergeCells('A4:D4');
                $sheet->mergeCells('A7:B7');
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
                $sheet->cell('A4', function($cell) {
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                });
                $sheet->cells('A6:D6', function($cells) {
                    $cells->setFontSize(12);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A7:D7', function($cells) {
                    $cells->setFontSize(12);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A'.$countFooter.':D'.$countFooter, function($cells) {
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
    private function saldo($seatings,$types){

        $type = $this->nameType($types);
        $saldo= $this->auxiliarySeatRepository->getModel()
            ->where('code',$seatings[0]->code)
            ->where('type_id',$type->id)
            ->where('status','aplicado')
            ->sum('amount');


        return $saldo;
    }
}