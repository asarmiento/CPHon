<?php

namespace AccountHon\Http\Controllers;


use AccountHon\Reposioties\DuesRepository;
use AccountHon\Reposioties\AffiliateRepository;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

abstract class ReportExcelController extends Controller
{

    private $duesRepository;
    private $affiliateRepository;

    public function __construct(
        DuesRepository  $duesRepository,
        AffiliateRepository $affiliateRepository
    ){

        $this->middleware('auth');
        $this->duesRepository= $duesRepository;
        $this->affiliateRepository= $affiliateRepository;
    }


    public function ReportAffiliate($token){

        $header = array(
                array('INSTITUCION DE PREVISION SOCIAL DEL PERIODISTA'),
                array('Carnet: ','',' Fecha Nacimiento: ', ' ', 'Edad: ', 'Fecha Ingreso: '),
                array('Nombre: '),
                array('Tiempo de jubilación Voluntaria: '),
                array('Tiempo de jubilación Obligatorio: '),
                array('Pago de Cuotas Sector Privado '),
                array(''),
                array('Año','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre')
            );

        $dues =  $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->orderBy('date_payment','ASC')->get();

        if(!$dues->isEmpty()){
            //"01/01/1995"
            $old_year = Carbon::format($dues[0]->date_payment)->getFullYear(); //1995
            $last_year = Carbon::format($dues[count($dues)-1])->getFullYear(); //2014
            
            for ($i = $old_year; $i <= $last_year  ; $i++) { 
                $row[] = $i;
                for ($j=1; $j <= 12 ; $j++) { 
                    # code...
                    foreach ($dues as $key => $value) {
                        if($value->date_payment == "01/".$j."/".$i){
                            array_push($row, $value->amount);
                        }else{
                            array_push($row, "");
                        }
                    }
                }
                array_push($header, $row);
            }

        }
ECHO json_encode($header); die;
     /*   foreach ($dues as $due) {
            $duesYear =  $this->duesRepository->getModel()->where('date_payment',$affiliate->id)->where('affiliate_id',$affiliate->id)->orderBy('date_payment','ASC')->get();
            foreach(){
                $header[] = ['Año','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
            }
            
        }*/
    }
  


}
