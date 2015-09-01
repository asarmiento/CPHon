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

use Carbon\Carbon;

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
        $affiliates = $this->affiliateRepository->all();

        $dues = array();
        foreach ($affiliates as $affiliate) {
            $dues_affiliate = $this->duesRepository->getModel()->where('affiliate_id', $affiliate->id)->limit(2)->offset(2)->orderBy('date_payment', 'desc')->get();
            //dd($dues_affiliate);
            if( ! $dues_affiliate->isEmpty() )
            {
                /*array_push($dues, $due[0]);
                array_push($dues, $due[1]);*/
                foreach ($dues_affiliate as $key => $due_affiliate) {
                    # code...
                    array_push($dues, $due_affiliate);
                }
            }
        }
        
        return View('dues.index',compact('dues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        set_time_limit(0);
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
        set_time_limit(0);
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
            $comprobacion = $this->duesRepository->getModel()->where('affiliate_id',$affiliateRecordPercentages->id)
            ->where('date_payment',$affiliate['date_payment'])
            ->where('type','affiliate')->orderBy('date_payment','DESC')->get();

           
           
            if(count($comprobacion) > 0):

            else:
                if(count($affiliate['amount_affiliate']) > 0):
                    $typeAffiliate = $affiliate;
                    unset($typeAffiliate['amount']);
                    $typeAffiliate['salary']= $typeAffiliate['amount_affiliate'] / ($recordPercentages->percentage_affiliates/100);
                    $typeAffiliate['type']= 'affiliate';
                    $typeAffiliate['amount']= $typeAffiliate['amount_affiliate'];
                     unset($typeAffiliate['amount_affiliate']);
                    unset($typeAffiliate['code']); 
                    $data =  $affiliateRecordPercentages->RecordPercentages()->attach( $recordPercentages->id,$typeAffiliate );
                endif;
            endif;

            $comprobacionPrivet = $this->duesRepository->getModel()->where('affiliate_id',$affiliateRecordPercentages->id)
            ->where('date_payment',$affiliate['date_payment'])
            ->where('type','privado')->orderBy('date_payment','DESC')->get();
           
            if(count($comprobacionPrivet) > 0):

            else:
                 $typeAffiliate = $affiliate;
                unset($typeAffiliate['amount_affiliate']);
                if(count($affiliate['amount']) > 0):
                    $typeAffiliate['salary']= $typeAffiliate['amount'] / ($recordPercentages->percentage/100);
                    $typeAffiliate['type']= 'privado';
                    unset($typeAffiliate['code']); 
                    $data =  $affiliateRecordPercentages->RecordPercentages()->attach( $recordPercentages->id,$typeAffiliate );
                endif;
            endif;


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
     * @param  int  $token
     * @return Response
     */
    public function edit($token)
    {
        $due = $this->duesRepository->getModel()->where('token',$token)->with('affiliates')->first();
        $due->date_payment = Carbon::parse($due->date_payment)->format('d/m/Y');
        $due->date_dues    = Carbon::parse($due->date_dues)->format('d/m/Y');
        $arrDatePayment = explode('/',$due->date_payment);
        $due->date_payment = $arrDatePayment[1].'/'.$arrDatePayment[2];
        return $due;
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

        $affiliate = $this->CreacionArray($request->all(),'Affiliate');
        $affiliate = $this->CreacionArray($affiliate,'Dues');
        $duesPrivateId = $this->duesRepository->getModel()->Where('token',$request->get('token'))->where('type','privado')->get();
        $duesPrivate= $this->duesRepository->find($duesPrivateId[0]->id);
        $affiliateDues = $affiliate;
        unset($affiliateDues['amount_affiliate']);
        $duesPrivate->fill($affiliateDues);
        $duesPrivate->update();
        unset($affiliate['amount']);
        $affiliate['amount']= $affiliate['amount_affiliate'];
        unset($affiliate['amount_affiliate']);
        $duesAffiliateId = $this->duesRepository->getModel()->Where('token',$request->get('token'))->where('type','affiliate')->get();
        $duesAffiliate= $this->duesRepository->find($duesAffiliateId[0]->id);
        $duesAffiliate->fill($affiliate);
        $duesAffiliate->update();

    }

}
