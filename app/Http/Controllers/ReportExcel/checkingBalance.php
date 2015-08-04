<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 05/07/2015
 * Time: 06:16 PM
 */

namespace AccountHon\Http\Controllers\ReportExcel;


use AccountHon\Http\Controllers\ReportExcelController;
use Maatwebsite\Excel\Facades\Excel;

class checkingBalance extends ReportExcelController{


    public function index(){
        $periods   = $this->accountingPeriodRepository->orderBy('period', 'asc');
        $last      = count($periods) - 1;

        $periodInitial = $periods[0]->month.'/'.$periods[0]->year;
        $periodFinal   = $periods[$last]->month.'/'.$periods[$last]->year;

        return view('reports.checkingBalance', compact('periodInitial', 'periodFinal'));
    }


/*
    public function report(){ set_time_limit(0);
      /*  $rangePeriods = $this->convertionObjeto();
        $range = explode(' - ', $rangePeriods->range);
        $rangeIni = explode('/', $range[0]); 
        $rangeFin = explode('/', $range[1]);

        $periodInitial = "02/2015";//$rangeIni[1].$rangeIni[0];

        $periodFinal =  "06/2015";//$rangeFin[1].$rangeFin[0];*/


    public function report($rangePeriods){ 
        set_time_limit(0);
        //$rangePeriods = $this->convertionObjeto();
        $range = explode('-', $rangePeriods);

        $periodInitial = $range[0];
        $periodFinal   =  $range[1];
        

        $periods = $this->accountingPeriodRepository->listsRange(array($periodInitial,$periodFinal), 'period',  'id');
        
        $catalogs = $this->catalogRepository->getModel()->where('style','Detalle')->where('school_id',userSchool()->id)->orderBy('code','ASC')->get();


        $content = array(
            array(userSchool()->name),
            array('BALANCE DE COMPROBACIÓN'),
            array(''),
            array('CODIGO','NOMBRE DE CUENTA','SALDO INICIAL','DEBITO PERIODO','CREDITO PERIODO','BALANCE FINAL'),
        );
        $countHeader = count($content);
        $inicial=0;  $Tinicial=0;
        $debito =0;  $Tdebito =0;
        $credito=0;  $Tcredito=0;
        $balance=0;  $Tbalance=0;
        foreach($catalogs AS $catalog):

            $inicial = $this->saldoInicialCatalog($catalog->id,$periodInitial);
            $debito =$this->saldoPeriod($catalog->id,$periods,'DEBITO');
            
            $credito =$this->saldoPeriod($catalog->id,$periods,'CREDITO');
            $balance =($inicial+$debito)-$credito;
            $Tinicial+= $inicial;
            $Tdebito += $debito ;
            $Tcredito+= $credito;
            $Tbalance += $balance;
          /*  if($balance>0):
                $balance =$balance;
                else:
                    $balance= -0-$balance;
                    $balance= $balance.' cr';
                    endif;*/
            $content[]= array($catalog->code,$catalog->name,
                $this->saldoInicialCatalog($catalog->id,$periodInitial),
                $debito,
                $credito,$balance);

        endforeach; 
        $countContent = count($content);
        $content[]= array('','TOTAL',$Tinicial,$Tdebito,$Tcredito,$Tbalance);
        $countFooter = count($content);
        Excel::create(date('d-m-Y').'- Balance Comprobación', function($excel) use ($catalog,$content,$countHeader,$countContent,$countFooter) {
            $excel->sheet('Balance Comprobación', function($sheet)  use ($content,$countHeader,$countContent,$countFooter) {
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $sheet->mergeCells('A3:F3');
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
                $sheet->cells('A'.$countHeader.':F'.$countHeader, function($cells) {
                    $cells->setFontSize(12);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                $sheet->cells('A'.$countFooter.':F'.$countFooter, function($cells) {
                    $cells->setFontSize(12);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                $sheet->fromArray($content, null, 'A1', true,false);
            });
        })->export('xlsx');
    }


    public function saldoPeriod($catalog,$period,$type){

        return $this->balancePeriodRepository->saldoPeriod($catalog,$period,$type);

    }

    public function saldoInicialCatalog($catalog,$period){
        $saldo = $this->balancePeriodRepository->saldoIncial($period,'period',$catalog);
        return $saldo;
    }



    public function saldoPeriodCatalog($catalog,$periods,$type){
                $type = $this->nameType($type);
        $saldo = 0;

        foreach($periods AS $key => $period): //dd($period);
        $saldo += $this->seatingRepository->catalogPeriod($catalog,$period,$type);
            endforeach;
        return $saldo;
    }

    public function saldoPeriodCatalogPart($catalog,$periods,$type){
        $type = $this->nameType($type);
        $saldo = 0;

        foreach($periods AS $key => $period): //dd($period);
            $saldo += $this->seatingRepository->catalogPartPeriod($catalog,$period,$type);
        endforeach;
        return $saldo;
    }
}