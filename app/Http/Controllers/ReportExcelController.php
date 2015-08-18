<?php

namespace AccountHon\Http\Controllers;




use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

abstract class ReportExcelController extends Controller
{

  

    public function __construct(
        
    ){

        $this->middleware('auth');
        
    }


    public function ReportAffiliate(){

        $header = array(
                array('INSTITUCION DE PREVISION SOCIAL DEL PERIODISTA'),
                array(),
                array(),
                array(),
                array(),
            );
    }
  


}
