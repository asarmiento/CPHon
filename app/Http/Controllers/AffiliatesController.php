<?php

namespace AccountHon\Http\Controllers;

use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\AffiliateRepository;
use AccountHon\Repositories\DuesRepository;
use \Carbon\Carbon;

class AffiliatesController extends Controller
{
    private $affiliateRepository;
    private $duesRepository;

    public function __construct(
        AffiliateRepository $affiliateRepository,
        DuesRepository $duesRepository
        )
    {
        $this->middleware('auth');
        $this->affiliateRepository = $affiliateRepository;
        $this->duesRepository = $duesRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $affiliates = $this->affiliateRepository->all();
        return View('affiliates.index',compact('affiliates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View('affiliates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
          $date = \Carbon\Carbon::now();
        $affiliate = $this->CreacionArray($request->all(),'Affiliate');
        $affiliate['birthdate']= \Carbon\Carbon::createFromFormat('d/m/Y', $affiliate['birthdate'])->toDateString();
        $affiliate['affiliation']= $date->now()->toDateString();
        $affiliate['status']= 'Activo';
        $affiliates = $this->affiliateRepository->getModel();
        if($affiliates->isValid($affiliate)):
        $affiliates->fill($affiliate);
        $affiliates->save();
        return $this->exito('Se ha Guardado con exito !!!');
        endif;

         return $this->errores($affiliates->errors);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $token
     * @return Response
     */
    public function edit($token)
    {
        $affiliate = $this->affiliateRepository->token($token);
        return $affiliate;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $token)
    {
        $affiliate = $this->CreacionArray($request->all(),'Affiliate');
        $affiliate['affiliation']= date('Y-m-d');
        $affiliate['status']= 'Activo';
        $affiliates = $this->affiliateRepository->token($token);
        if($affiliates->isValid($affiliate)):
        $affiliates->fill($affiliate);
        $affiliates->save();
        return $this->exito('Se ha Guardado con exito !!!');
        endif;

         return $this->errores($affiliates->errors);
    }

    public function search(){
         $code = \Input::get('code');
         $affiliates = $this->affiliateRepository->getModel()->orWhere('code', 'LIKE', '%'.$code.'%' )
         ->orWhere('fname', 'LIKE', '%'.$code.'%')->orWhere('flast', 'LIKE', '%'.$code.'%')->get();
         $data = array();
         foreach ($affiliates as $affiliate) {
           
            $payments= $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->groupBy('affiliate_id')->orderBy('date_payment','DESC')->get();

            foreach ($payments as $payment) {
              if($affiliate->id == $payment->affiliate_id):
                    $affiliate->lastPayment = $payment->date_payment;
                 
                   endif;

            } 
            $data[] = $affiliate;
        }
     //    echo json_encode($affiliate );    die;
         return $data;
    }

    public function report($token){
        $affiliate = $this->affiliateRepository->token($token);

        $dues =  $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->orderBy('date_payment','ASC')->get();

        if(!$dues->isEmpty()){
            $old_year = Carbon::parse($dues[0]->date_payment)->year;
            $last_year = Carbon::parse($dues[count($dues)-1]->date_payment)->year;
            $header = array();
            for ($i = $old_year; $i <= $last_year ; $i++) { 
                $row = array();
                $row[] = $i;
                for ($j=1; $j <= 12 ; $j++) { 
                    foreach ($dues as $key => $value) {
                        if(Carbon::parse($value->date_payment)->year == $i && Carbon::parse($value->date_payment)->month == $j){
                            array_push($row, $value->amount);
                        }
                    }
                    if(count($row) == $j){
                        array_push($row, "");
                    }
                }
                array_push($header, $row);
            }
        }
        $dateNow = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->toDateTimeString())->format('d-m-Y H:i:s');
        $arrDateNow = explode(" ", $dateNow);

        $birthdate = new Carbon($affiliate->birthdate);
        $now = Carbon::now();
        
        $age = $birthdate->diffInYears($now);

        return view('affiliates.report.main', compact('affiliate', 'dues', 'arrDateNow', 'age'));
    }
}
