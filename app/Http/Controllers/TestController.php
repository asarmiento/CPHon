<?php

namespace AccountHon\Http\Controllers;


use AccountHon\Entities\Catalog;
use AccountHon\Entities\Cost;
use AccountHon\Entities\Seating;
use AccountHon\Entities\Student;
use AccountHon\Entities\TypeForm;
use AccountHon\Entities\User;
use AccountHon\Entities\BalanceBudget;
use AccountHon\Entities\Transfer;
use AccountHon\Entities\Spreadsheet;

use AccountHon\Repositories\AccountingPeriodRepository;
use AccountHon\Repositories\AuxiliaryReceiptRepository;
use AccountHon\Repositories\AuxiliarySeatRepository;
use AccountHon\Repositories\BalancePeriodRepository;
use AccountHon\Repositories\CatalogRepository;

use AccountHon\Repositories\FinancialRecordsRepository;
use AccountHon\Repositories\SeatingRepository;
use AccountHon\Repositories\TypeFormRepository;
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
    private $financialRecordsRepository;


    /**
     * @param FinancialRecordsRepository $financialRecordsRepository
     */
    public function __construct(FinancialRecordsRepository $financialRecordsRepository){
        //$this->middleware('sessionOff');
        $this->financialRecordsRepository = $financialRecordsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        if(userSchool()){
            echo "School User";
        }else{
            echo "No user school";
        }die;
        Log::error($this->financialRecordsRepository->updateData('106','status','aplicado'));
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
