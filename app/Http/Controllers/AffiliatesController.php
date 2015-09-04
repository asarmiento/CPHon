<?php

namespace AccountHon\Http\Controllers;

use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\AffiliateRepository;
use AccountHon\Repositories\DuesRepository;
use AccountHon\Repositories\RecordPercentageRepository;
use \Carbon\Carbon;

class AffiliatesController extends Controller
{
    private $affiliateRepository;
    private $duesRepository;
    private $recordPercentagesRepository;

    public function __construct(
        AffiliateRepository $affiliateRepository,
        DuesRepository $duesRepository,
        RecordPercentageRepository $recordPercentagesRepository
        )
    {
        $this->middleware('auth');
        $this->affiliateRepository = $affiliateRepository;
        $this->duesRepository = $duesRepository;
        $this->recordPercentagesRepository = $recordPercentagesRepository;
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
        $affiliate->birthdate = Carbon::parse($affiliate->birthdate)->format('d/m/Y');
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
            $payment = $this->duesRepository->getModel()->where('affiliate_id',$affiliate->id)->orderBy('date_payment','DESC')->first();
            
            $affiliate->lastPayment = '';

            if( $payment )
            {
                $affiliate->lastPayment = Carbon::parse($payment->date_payment)->format('m/d/Y');
            }
            
            $data[] = $affiliate;
        }
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
        }

        if( $duesPrivate->isEmpty() )
        {
            $error_private = true;
        }
        
        if( isset($error_private) && isset($error_affiliate) )
        {
            $error = "El afiliado $affiliate->fname $affiliate->flast no cuenta con cuotas canceladas.";
            return view('errors.validate', compact('page', 'error'));
        }

        //Birthdate
        $birthdate = new Carbon($affiliate->birthdate);
        //Age
        $age       = $birthdate->diffInYears(Carbon::now());
        //Format Birthdate        
        $birthdate = $birthdate->format('d/m/Y');

        //Data for report affiliate
        $dataAffiliate = $this->prepareData($duesAffiliate, 'affiliate');

        //Data for report private
        $dataPrivate = $this->prepareData($duesPrivate, 'privado');
        
        //Dues total max, date of admission
        $dues_total_max = 0;
        if( $dataAffiliate[count($dataAffiliate)-1][2] >= $dataPrivate[count($dataPrivate)-1][2] )
        {
            $dues_total_max = $dataAffiliate[count($dataAffiliate)-1][2];
            $date_of_admission = $dataAffiliate[count($dataAffiliate)-1][0];
        }else{
            $dues_total_max = $dataPrivate[count($dataPrivate)-1][2];
            $date_of_admission = $dataPrivate[count($dataPrivate)-1][0];
        }

        //Date Now separed Date of Hours
        $arrDateNow = $this->arrDateNow();
        
        $pdf = \PDF::loadView('affiliates.report.main',
                    compact('arrDateNow', 'affiliate', 'birthdate', 'age', 'date_of_admission','dataPrivate',
                            'dues_total_max', 'dataAffiliate')
                )->setOrientation('portrait');
        return $pdf->stream("Reporte Contribución Afiliado -".$affiliate->fullname().".pdf");
    }

    /**
     * [prepareData description]
     * @param  [type] $dues [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    private function prepareData($dues, $type){
        $old_year  = Carbon::parse($dues[0]->date_payment)->year;
        $last_year = Carbon::parse($dues[count($dues)-1]->date_payment)->year;
        
        $recordPercentages = $this->recordPercentagesRepository->all();

        //Construye los porcentages de los afiliados en un array
        $percentages_affiliates = array();
        foreach ($recordPercentages as $key => $percentage) {
            //Construye los porcentages de los afiliados en un array [year, month, percentage]
            array_push( $percentages_affiliates, array(intval($percentage->year), intval($percentage->month), floatval($percentage->percentage_affiliates)) );
        }
        
        //Porcentaje actual - siempre el del año 1986
        $percentage_current = $percentages_affiliates[0][2];

        $dues_count = 0; //Contador de cuotas pagadas 
        $salary_accumulated = 0; //Salario acumulado
        $dues_total = 0; //Total de cuotas pagadas
        $data = array();
        //Recorre todos los años de las cuotas
        for ($i = $old_year; $i <= $last_year ; $i++) {
            //array que contiene información por cada año (año, [cuota, recibo, salario])
            $row   = array();
            $row[] = $i;
            $validate = false;
            //Recorre todos los meses del año
            for ($j=1; $j <= 12 ; $j++) {
                //Recorre todas las cuotas
                foreach ($dues as $key => $due) {
                    $yearDue = Carbon::parse($due->date_payment)->year;
                    $monthDue = Carbon::parse($due->date_payment)->month;

                    foreach ($percentages_affiliates as $percentage_affiliate) {
                        //Calcula el nuevo porcentaje según el array de porcentajes
                        if($percentage_affiliate[0] == $i && $percentage_affiliate[1] == $j)
                        {
                            $percentage_current = $percentage_affiliate[2];
                        }
                    }
                    //Evalua si el año y el mes son los mismos que las fecha de cuota
                    if($yearDue == $i && $monthDue == $j){
                        //Si existe el mes y año en el array -> se suma la cuota, se concatena el recibo y se suma el salario
                        if( array_key_exists($j, $row) )
                        {
                            //Si el valor es mayor que 0 se adiciona a la misma fila
                            if($due->amount > 0)
                            {
                                if($type == 'affiliate')
                                {
                                    if( ! $row[$j] );
                                    {
                                        if($dues_count == 0)
                                        {
                                            $first_date = '01/'.str_pad((string)$j, 2, "0", STR_PAD_LEFT).'/'.$i;
                                        }
                                        $dues_count++;
                                    }
                                    $amount = $row[$j][0] + (float) $due->amount;
                                    $consecutive = ($row[$j][1]) ? $row[$j][1].'-'.$due->consecutive : $due->consecutive;
                                    $salary = $row[$j][2] + (float) ($due->amount) * 100 / $percentage_current;
                                    $row[$j] = array($amount, $consecutive, $salary);
                                    $dues_total += $amount;
                                    $salary_accumulated += $salary;
                                }else{
                                    if( ! $row[$j] );
                                    {
                                        if($dues_count == 0)
                                        {
                                            $first_date = '01/'.str_pad((string)$j, 2, "0", STR_PAD_LEFT).'/'.$i;
                                        }
                                        $dues_count++;
                                    }
                                    $amount = $row[$j][0] + (float) $due->amount;
                                    $consecutive = ($row[$j][1]) ? $row[$j][1].'-'.$due->consecutive : $due->consecutive;
                                    $salary = $row[$j][2] + (float) $due->amount * 100 / 10;
                                    $row[$j] = array($amount, $consecutive, $salary);
                                    $dues_total += $amount;
                                    $salary_accumulated += $salary;
                                }
                                $validate = true;
                            }
                        }else{
                            //Si el valor es mayor que 0 se ingresa un nuevo dato a la fila
                            if($due->amount > 0)
                            {
                                if($type == 'affiliate')
                                {
                                    array_push($row,
                                            array( (float) $due->amount, $due->consecutive, (float) ($due->amount *100/$percentage_current))
                                    );
                                    if($dues_count == 0)
                                    {
                                        $first_date = '01/'.str_pad((string)$j, 2, "0", STR_PAD_LEFT).'/'.$i;
                                    }
                                    $dues_count++;
                                    $dues_total += $due->amount;
                                    $salary_accumulated += (float) $due->amount *100/$percentage_current;
                                }else{
                                    array_push($row, 
                                            array( (float) $due->amount, $due->consecutive, (float) ($due->amount *100/10) )
                                    );
                                    if($dues_count == 0)
                                    {
                                        $first_date = '01/'.str_pad((string)$j, 2, "0", STR_PAD_LEFT).'/'.$i;
                                    }
                                    $dues_count++;
                                    $dues_total += $due->amount;
                                    $salary_accumulated += $due->amount *100/10;
                                }
                                $validate = true;
                            }else{
                                array_push( $row, null );
                            }
                        }
                    }
                }
            }
            //Valida que en el año se haya ingresado al menos una cuota
            if($validate){
                array_push($data, $row);
            }
        }
        //dd($data[0]);
        //fecha de ingreso, salario total, contador de cuotas pagadas, total de cuotas pagadas
        array_push($data, array($first_date, $salary_accumulated,$dues_count, $dues_total));
        return $data;
    }

    private function arrDateNow(){
        $now = Carbon::now();
        $dateNow    = $now->format('d/m/Y H:i:s');
        $arrDateNow = explode(" ", $dateNow);
        return $arrDateNow;
    }

}
