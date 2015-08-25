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
    public function reportPrivate($token){
        
        $affiliate = $this->affiliateRepository->token($token);
        
        //Total dues for affiliate
        $dues      =  $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->orderBy('date_payment','ASC')->get();
        
        if($dues->isEmpty())
        {
            $page = 'Afiliados';
            $error = "El afiliado $affiliate->fname $affiliate->flast no cuenta con cuotas canceladas";
            return view('errors.validate', compact('page', 'error'));
        }

        //Data for report
        $data      = $this->prepareData($dues, 'private');
         
        //Total amount private 
        $total     = $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->sum('amount');
        
        //Salary by affiliate    
        $salary    = $total/0.1;
        $salary_prom = number_format($salary / count($dues));

        //Date Now separed Date of Hours
        $arrDateNow = $this->arrDateNow();
        
        //Birthdate
        $birthdate = new Carbon($affiliate->birthdate);
        //Age
        $age       = $birthdate->diffInYears(Carbon::now());
        //Format Birthdate        
        $birthdate = $birthdate->format('d/m/Y');
        
        //First Due - Reference date_payment
        $first_due    = new Carbon($dues[0]->date_payment);
        
        //Dues total (compare Now - First Due)
        $dues_total   = Carbon::now()->diffInMonths($first_due);
        
        //Dues total payment
        $dues_payment = count($dues);
        
        //Date Affiliate
        $date_affiliate = Carbon::createFromFormat("Y-m-d", $affiliate->affiliation)->format('d/m/Y');

        //return view('affiliates.report.private.main', compact('arrDateNow', 'affiliate', 'birthdate', 'age', 'date_affiliate', 'data', 'dues_total', 'dues_payment', 'salary_prom'));

        $pdf = \PDF::loadView('affiliates.report.private.main', compact('arrDateNow', 'affiliate', 'birthdate', 'age', 'date_affiliate', 'data', 'dues_total', 'dues_payment', 'salary_prom'))->setOrientation('portrait');
        return $pdf->stream("Reporte Sector Privado -".$affiliate->fullname().".pdf");
    }

    /**
     * [report description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function reportAffiliate($token){
        
        $affiliate = $this->affiliateRepository->token($token);
        
        //Total dues for affiliate
        $dues      =  $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->orderBy('date_payment','ASC')->get();
        
        if($dues->isEmpty())
        {
            $page = 'Afiliados';
            $error = "El afiliado $affiliate->fname $affiliate->flast no cuenta con cuotas canceladas";
            return view('errors.validate', compact('page', 'error'));
        }

        //Data for report
        $data      = $this->prepareData($dues, 'affiliate');
        
        //Date Now separed Date of Hours
        $arrDateNow = $this->arrDateNow();
        
        //First Due - Reference date_payment
        $first_due    = new Carbon($dues[0]->date_payment);
        
        //Dues total (compare Now - First Due)
        $dues_total   = Carbon::now()->diffInMonths($first_due);
        
        //Dues total payment
        $dues_payment = count($dues);
        
        //return view('affiliates.report.affiliate.main', compact('arrDateNow', 'affiliate', 'data', 'dues_total', 'dues_payment'));

        $pdf = \PDF::loadView('affiliates.report.affiliate.main', compact('arrDateNow', 'affiliate', 'data', 'dues_total', 'dues_payment'))->setOrientation('portrait');
        return $pdf->stream("Reporte Contribución Afiliado -".$affiliate->fullname().".pdf");
    }

    /**
     * [report description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function reportSalary($token){
        
        $affiliate = $this->affiliateRepository->token($token);
        
        //Total dues for affiliate
        $dues      =  $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->orderBy('date_payment','ASC')->get();
        
        if($dues->isEmpty())
        {
            $page = 'Afiliados';
            $error = "El afiliado $affiliate->fname $affiliate->flast no cuenta con cuotas canceladas";
            return view('errors.validate', compact('page', 'error'));
        }
        
        //Data for report
        $data      = $this->prepareData($dues, 'private');
        
        //Date Now separed Date of Hours
        $arrDateNow = $this->arrDateNow();
        
        //First Due - Reference date_payment
        $first_due    = new Carbon($dues[0]->date_payment);
        
        //Dues total (compare Now - First Due)
        $dues_total   = Carbon::now()->diffInMonths($first_due);
        
        //Dues total payment
        $dues_payment = count($dues);

        //Total Amount affiliate
        $total_affiliate = $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->sum('amount_affiliate');

        //Total Amount private
        $total_private = $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->sum('amount');
        
        //return view('affiliates.report.salary.main', compact('arrDateNow', 'affiliate', 'data', 'dues_total', 'dues_payment', 'total_private', 'total_affiliate'));

        $pdf = \PDF::loadView('affiliates.report.salary.main', compact('arrDateNow', 'affiliate', 'data', 'dues_total', 'dues_payment', 'total_private', 'total_affiliate'))->setOrientation('portrait');
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
                foreach ($dues as $key => $value) {
                    if(Carbon::parse($value->date_payment)->year == $i && Carbon::parse($value->date_payment)->month == $j){
                        if( array_key_exists($j, $row) ){
                            if($type == 'private'){
                                $row[$j] = $value->amount + $row[$j];
                            }else{
                                $row[$j] = $value->amount_affiliate + $row[$j];
                            }
                        }else{
                            if($type == 'private'){
                                array_push($row, $value->amount);
                            }else{
                                array_push($row, $value->amount_affiliate);;
                            }
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
