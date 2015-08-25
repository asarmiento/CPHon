<?php

namespace AccountHon\Http\Controllers;

use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\AffiliateRepository;
use AccountHon\Repositories\RecordPercentageRepository;
use AccountHon\Repositories\DuesRepository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AffiliatesRecordPercentageController extends Controller
{
    
    private $affiliateRepository;
    private $recordPercentageRepository;
    private $duesRepository;

    public function __construct(
        AffiliateRepository $affiliateRepository,
        DuesRepository $duesRepository,
        RecordPercentageRepository $recordPercentageRepository

        )
    {
        $this->middleware('auth');
        $this->affiliateRepository = $affiliateRepository;
        $this->recordPercentageRepository=$recordPercentageRepository;
        $this->duesRepository=$duesRepository;
    }    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

         set_time_limit(0);
        //$dues = $this->duesRepository->getModel()->limit(100)->offset(100)->get();
        $dues = $this->duesRepository->getModel()->orderBy('id','desc')->limit(100)->offset(100)->get();
  
        return View('dues.index',compact('dues'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $affiliates = $this->affiliateRepository->all();
        
        return View('dues.create',compact('affiliates','recordPercentages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
       try{
        DB::beginTransaction();
            #
            
              
            $affiliate = $this->CreacionArray($request->all(),'Affiliate');
            #
            $date= explode('/', $affiliate['date_payment']); 
            $affiliate['date_payment'] = $date[1]."-".$date[0]."-01";
            #
            $affiliates = $this->affiliateRepository->getModel()->where('code',$affiliate['code'])->get();
            #
            $recordPercentages = $this->recordPercentageRepository->token($affiliate['token'] );
            $affiliate['record_percentage_id']= $recordPercentages->id;
            #
            unset($affiliate['token']); 
            $affiliate = $this->CreacionArray($affiliate,'Dues');
            #
            $affiliateRecordPercentages = $this->affiliateRepository->find($affiliates[0]->id);
            #

            unset($affiliate['code']); 
           $data =  $affiliateRecordPercentages->RecordPercentages()->attach( $recordPercentages->id,$affiliate );
         
             DB::commit();
                return $this->exito('Se ha Guardado con exito');
                
      } catch (Exception $e) {
            Log::error($e);
            DB::rollback();
            return $this->errores(['error'=>' se ha generado un error verificar los datos']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

}
