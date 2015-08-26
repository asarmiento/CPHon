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

    /**
     * [report description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function report($token){
        
        $affiliate = $this->affiliateRepository->token($token);
        
        //Total dues for Affiliate
        $duesAffiliate =  $this->duesRepository->getModel()->where('type','affiliate')->where('affiliate_id',$affiliate->id)->orderBy('date_payment','ASC')->get();

        //Total dues for Private
        $duesPrivate = $this->duesRepository->getModel()->where('type','privado')->where('affiliate_id',$affiliate->id)->orderBy('date_payment','ASC')->get();
        
        $error = '';
        $page  = 'Afiliados';

        if( $duesAffiliate->isEmpty() )
        {
            $error_affiliate = true;
            $error = "El afiliado $affiliate->fname $affiliate->flast no cuenta con cuotas canceladas.";
        }

        if( $duesPrivate->isEmpty() )
        {
            $error_private = true;
            $error = "El afiliado $affiliate->fname $affiliate->flast no cuenta con cuotas canceladas.";
        }
        
        if( isset($error_private) && isset($error_affiliate) )
        {
            return view('errors.validate', compact('page', 'error'));
        }

        //Birthdate
        $birthdate = new Carbon($affiliate->birthdate);
        //Age
        $age       = $birthdate->diffInYears(Carbon::now());
        //Format Birthdate        
        $birthdate = $birthdate->format('d/m/Y');

        //Date Affiliate
        $date_affiliate = Carbon::createFromFormat("Y-m-d", $affiliate->affiliation)->format('d/m/Y');

        //Data for report affiliate
        $dataAffiliate = $this->prepareData($duesAffiliate, 'affiliate');

        //Data for report private
        $dataPrivate = $this->prepareData($duesPrivate, 'privado');
        
        //Date Now separed Date of Hours
        $arrDateNow = $this->arrDateNow();
        
        //First Due Affiliate - Reference date_payment
        $first_due_affiliate  = new Carbon($duesAffiliate[0]->date_payment);

        //First Due Private - Reference date_payment
        $first_due_private  = new Carbon($duesPrivate[0]->date_payment);
        
        //Dues total (compare Now - First Due) Affiliate 
        $dues_total_affiliate = Carbon::now()->diffInMonths($first_due_affiliate);

        //Dues total (compare Now - First Due) Private 
        $dues_total_private = Carbon::now()->diffInMonths($first_due_private);

        //Dues total payment
        $dues_payment_affiliate = count($duesAffiliate);

        //Dues total private
        $dues_payment_private = count($duesPrivate);

        //Total Salary affiliate
        $salary_affiliate = $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->where('type', 'affiliate')->sum('salary');

        //Salary prom by affiliate    
        $salary_prom_affiliate = number_format( ($salary_affiliate / $dues_payment_affiliate), 2);

        //Total Salary private
        $salary_private = $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->where('type', 'privado')->sum('salary');

        //Salary prom by private    
        $salary_prom_private = number_format( ($salary_private / $dues_payment_private), 2);

        //Total Amount affiliate
        $amount_affiliate = $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->where('type', 'affiliate')->sum('amount');

        //Total Amount private
        $amount_private = $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->where('type', 'private')->sum('amount');

        //return view('affiliates.report.salary.main', compact('arrDateNow', 'affiliate', 'data', 'dues_total', 'dues_payment', 'total_private', 'total_affiliate'));
        $pdf = \PDF::loadView('affiliates.report.main',
                    compact('affiliate', 'birthdate', 'age', 'date_affiliate', 'dataAffiliate',
                            'salary_affiliate', 'salary_prom_affiliate', 'salary_private', 
                            'salary_prom_private', 'amount_affiliate', 'amount_private',
                            'dataPrivate', 'arrDateNow', 'first_due_affiliate', 'first_due_private',
                            'dues_total_affiliate', 'dues_total_private', 'dues_payment_affiliate',
                            'dues_payment_private', 'total_affiliate', 'total_private')
                    )->setOrientation('portrait');
        return $pdf->stream("Reporte Contribución Afiliado -".$affiliate->fullname().".pdf");
    }

    /**
     * [prepareData description]
     * @param  [type] $dues [description]
     * @return [type]       [description]
     */
    private function prepareData($dues, $type){

        $old_year  = Carbon::parse($dues[0]->date_payment)->year;
        $last_year = Carbon::parse($dues[count($dues)-1]->date_payment)->year;
        
        $data = array();
        for ($i = $old_year; $i <= $last_year ; $i++) {
            $row   = array();
            $row[] = $i;
            for ($j=1; $j <= 12 ; $j++) {
                foreach ($dues as $key => $due) {
                    if(Carbon::parse($due->date_payment)->year == $i && Carbon::parse($due->date_payment)->month == $j){
                        if( array_key_exists($j, $row) )
                        {
                            $amount = $row[$j][0] + $due->amount;
                            $consecutive = $row[$j][1].'-'.$due->consecutive;
                            $salary = $row[$j][2] + $due->salary;
                            $row[$j] = array($amount, $consecutive, $salary);
                        }else{
                            array_push($row, array($due->amount, $due->consecutive, $due->salary));
                        }
                    }
                }
                if(count($row) == $j){
                    array_push($row, "");
                }
            }
            array_push($data, $row);
        }

        return $data;
    }

    private function arrDateNow(){
        $now = Carbon::now();
        $dateNow    = $now->format('d/m/Y H:i:s');
        $arrDateNow = explode(" ", $dateNow);
        return $arrDateNow;
    }

}
