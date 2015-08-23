<?php

namespace AccountHon\Http\Controllers;



use Illuminate\Contracts\Auth\Guard;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends controller
{
    /**
     * @var FinancialRecordsRepository
     */
    


    /**
     * @param FinancialRecordsRepository $financialRecordsRepository
     */
    public function __construct(){
      
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        return view('test.index');
    }

    public function post(){
        $file = \Input::file();
        dd($file);
    }


  /*  public function catalogSaldo($catalog,$period,$type){

        return Seating::where('type_id',$type)
            ->where('accounting_period_id',$period)
            ->where('catalog_id',$catalog)->sum('amount');
    }

   public function catalogPartSaldo($catalog,$period,$type){

        return Seating::where('type_id' ,$type)
            ->where('accounting_period_id',$period)
            ->where('catalogPart_id',$catalog)->sum('amount');
    }*/


}
