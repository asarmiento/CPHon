<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Entities\SeatingPart;
use AccountHon\Entities\TypeForm;/*
use AccountHon\Repositories\CatalogRepository;/
use AccountHon\Repositories\AccountingPeriodRepository;
use AccountHon\Repositories\SeatingPartRepository;
use AccountHon\Repositories\SeatingRepository;
use AccountHon\Repositories\TypeFormRepository;
use AccountHon\Repositories\TypeSeatRepository;*/
use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SeatingPartsController extends Controller
{
    /**
     * @var SeatingController
     */
    private $seatingController;

    /**
     * @param SeatingController $seatingController
     */
    public function __construct(SeatingController $seatingController){

        $this->seatingController = $seatingController;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function createArray($Validation,$verification)
    {

        if($verification->count()>0):
            $Validation['token']= $verification[0]->token;
            $Validation['date']= $verification[0]->date;
        endif;


        $typeSeat = $this->typeSeatRepository->token($Validation['typeSeat']);
        unset($Validation['typeSeat']);
        $Validation['type_seat_id']= $typeSeat->id;
        $catalog = $this->catalogRepository->token($Validation['account']);
        unset($Validation['account']);
        $Validation['catalog_id'] = $catalog->id;
        $type=$this->typeFormRepository->token($Validation['type']);
        unset($Validation['type']);
        $Validation['type_id']= $type->id;
        $period = $this->AccountingPeriodRepository->token($Validation['accoutingPeriod']);
        unset($Validation['accoutingPeriod']);
        $Validation['accounting_period_id']=$period->id;
        $Validation['status'] = 'no aplicado';
        $Validation['user_created'] = Auth::user()->id;


        return $Validation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
