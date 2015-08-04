<?php

namespace AccountHon\Http\Controllers\ReportExcel;
use AccountHon\Http\Controllers\ReportExcelController;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 04/07/2015
 * Time: 10:49 PM
 */

class EstadoDeCuenta extends ReportExcelController {

    /**
     * @param $token
     */
    public function estadoCuenta($token){ echo json_encode($token); die;

        $school = $this->schoolsRepository->whereId('id',userSchool()->id,'id');
        /** @var TYPE_NAME $catalog */
        $catalog = $this->catalogRepository->token($token);
        $seatings= $this->seatingRepository->whereDuo('catalog_id',$catalog->id,'status','aplicado','id','ASC');
        $headers = array(
            array($school[0]->name),
            array('ESTADO DE CUENTA'),
            array($catalog->code.' '.$catalog->name),
            array(''),
            array('Fecha','Descripción','Referencia','Debito','Credito')
        );
        $content = $headers;
        $countHeader = count($headers);
        foreach($seatings AS $seating):
            $seatingParts = $this->seatingPartRepository->getModel()->where('seating_id',$seating->id)->get();
            echo json_encode($seatingParts); die;
            if($seating->types->name=='DEBITO'):
                $content[] = array($seating->date,$seating->detail,$seating->code,$seating->amount,'');
            else:
             $content[] = array($seating->date,$seating->detail,$seating->code,'',$seating->amount);
           endif;
            foreach($seatingParts AS $seatingPart):
                if($seating->types->name=='DEBITO'):
                    $content[] = array($seatingPart[]->date,$seatingPart->detail,$seatingPart->code,'',$seatingPart->amount);
                else:
                    $content[] = array($seatingPart->date,$seatingPart->detail,$seatingPart->code,$seatingPart->amount,'');
                endif;
            endforeach;
        endforeach;
        $countContent = count($content);
        $content[] = array('','Fecha de Impresión: '.date('d-m-Y'),'Saldo ',$this->saldoEstadoCuenta($catalog));
        $countFooter = count($content);
       //
        Excel::create(date('d-m-Y').'-'.$catalog->name, function($excel) use ($catalog,$content,$countHeader,$countContent,$countFooter) {
            $excel->sheet($catalog->code, function($sheet)  use ($content,$countHeader,$countContent,$countFooter) {
                $sheet->mergeCells('A1:E1');
                $sheet->mergeCells('A2:E2');
                $sheet->mergeCells('A3:E3');
                $sheet->mergeCells('D'.$countFooter.':E'.$countFooter);
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
    private function saldoEstadoCuenta($catalog){

        $debito = $this->nameType('DEBITO');
        $credito = $this->nameType('CREDITO');
        $seatingsDebito= $this->seatingRepository->getModel()
            ->where('catalog_id',$catalog->id)
            ->where('type_id',$debito->id)
            ->where('status','aplicado')
            ->sum('amount');

        $seatingsCredito= $this->seatingRepository->getModel()
            ->where('catalog_id',$catalog->id)
            ->where('type_id',$credito->id)
            ->where('status','aplicado')
            ->sum('amount');

        $total = $seatingsDebito-$seatingsCredito;

        return $total;
    }
}