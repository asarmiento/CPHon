<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Entities\TypeForm;
use AccountHon\Repositories\AccountingPeriodRepository;
use AccountHon\Repositories\AuxiliarySeatRepository;
use AccountHon\Repositories\DegreesRepository;
use AccountHon\Repositories\FinancialRecordsRepository;
use AccountHon\Repositories\PeriodsRepository;
use AccountHon\Repositories\StudentRepository;
use AccountHon\Repositories\TypeFormRepository;
use AccountHon\Repositories\TypeSeatRepository;
use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


class AuxiliarySeatController extends Controller
{
    /**
     * @var DegreesRepository
     */
    private $degreesRepository;
    /**
     * @var TypeFormRepository
     */
    private $typeFormRepository;
    /**
     * @var TypeSeatRepository
     */
    private $typeSeatRepository;
    /**
     * @var FinancialRecordsRepository
     */
    private $financialRecordsRepository;
    /**
     * @var PeriodsRepository
     */
    private $periodsRepository;
    /**
     * @var AuxiliarySeatRepository
     */
    private $auxiliarySeatRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var AccountingPeriodRepository
     */
    private $accountingPeriodRepository;
    /**
     * @var TempAuxiliarySeatController
     */
    private $tempAuxiliarySeatController;

    /**
     * @var Route
     */


    /**
     * @param DegreesRepository $degreesRepository
     * @param TypeFormRepository $typeFormRepository
     * @param TypeSeatRepository $typeSeatRepository
     * @param FinancialRecordsRepository $financialRecordsRepository
     * @param PeriodsRepository $periodsRepository
     * @param AuxiliarySeatRepository $auxiliarySeatRepository
     * @param StudentRepository $studentRepository
     * @param AccountingPeriodRepository $accountingPeriodRepository
     * @param TempAuxiliarySeatController $tempAuxiliarySeatController
     * @param AuxiliarySeatController $auxiliarySeatController
     * @internal param Route $route
     */
    public function __construct(
        DegreesRepository $degreesRepository,
        TypeFormRepository $typeFormRepository,
        TypeSeatRepository $typeSeatRepository,
        FinancialRecordsRepository $financialRecordsRepository,
        PeriodsRepository $periodsRepository,
        AuxiliarySeatRepository $auxiliarySeatRepository,
        StudentRepository $studentRepository,
        AccountingPeriodRepository $accountingPeriodRepository,
        TempAuxiliarySeatController $tempAuxiliarySeatController

    ){
        set_time_limit(0);
        $this->middleware('auth');
        $this->middleware('sessionOff');
        $this->degreesRepository = $degreesRepository;
        $this->typeFormRepository = $typeFormRepository;
        $this->typeSeatRepository = $typeSeatRepository;
        $this->financialRecordsRepository = $financialRecordsRepository;
        $this->periodsRepository = $periodsRepository;
        $this->auxiliarySeatRepository = $auxiliarySeatRepository;
        $this->studentRepository = $studentRepository;
        $this->accountingPeriodRepository = $accountingPeriodRepository;
        $this->tempAuxiliarySeatController = $tempAuxiliarySeatController;

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $typeSeat = $this->typeSeatRepository->whereDuoData('DGA');

        if($typeSeat->isEmpty()):
            Log::warning('No existe tipo de asiento DG: en la institucion '.userSchool()->name);
            abort(500,'prueba');
        endif;
        $auxiliarySeats = $this->auxiliarySeatRepository->whereDuo('status', 'aplicado','type_seat_id',$typeSeat[0]->id,'id','ASC');
       // echo json_encode($auxiliarySeats); die;
        return View('auxiliarySeats.index', compact('auxiliarySeats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if(userSchool()):
            if(periodSchool()):
                $types    = $this->typeFormRepository->getModel()->all();
                $typeSeat = $this->typeSeatRepository->whereDuoData('DGA');
                if($typeSeat->isEmpty()):
                    Log::warning('No existe tipo de asiento DGA: en la institucion , class '.__class__.', function '.__function__);
                    abort(500);
                endif;
                /**pendiente solo debe enviar los estudiantes de la institucion*/
                $financialRecords = $this->financialRecordsRepository->whereId('year',periodSchool()->year, 'year');
                $auxiliarySeats   = $this->auxiliarySeatRepository->whereDuo('status','no aplicado','type_seat_id',$typeSeat[0]->id,'id','ASC');
                if(!$auxiliarySeats->isEmpty()):
                    $total = $this->auxiliarySeatRepository->getModel()->where('code',$auxiliarySeats[0]->code)->where('type_seat_id',$typeSeat[0]->id)->groupBy('code')->sum('amount');
                endif;
                return View('auxiliarySeats.create', compact('types','typeSeat','financialRecords','auxiliarySeats','total'));
            endif;
            return $this->errores('No tiene periodos contables Creados');
        endif;
        Log::info('El usuario intento ingresar a , class '.__class__.', function '.__function__.' Directamente'.currentUser()->name);
        return Redirect::to('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try{
            $auxiliary = $this->convertionObjeto();
            $verification=$this->auxiliarySeatRepository->whereId('code',$auxiliary->codeAuxiliarySeat,'updated_at');
            $Validation = $this->CreacionArray($auxiliary, 'AuxiliarySeat');

            if($verification->count()>0):
                $Validation['token']= $verification[0]->token;
                $Validation['date']= $verification[0]->date;
            endif;

            $type=$this->typeFormRepository->token($Validation['type']);
            $Validation['type_id']= $type->id;


            /* Creamos un array para cambiar nombres de parametros */
            $Validation['user_created'] = Auth::user()->id;
            $student = $this->studentRepository->token($Validation['financialRecord']);
            $Validation['financial_records_id'] = $student->financialRecords->id;
            $Validation['status'] = 'no aplicado';
            $Validation['accounting_period_id']= periodSchool()->id;
            $typeSeat=$this->typeSeatRepository->whereDuoData('DGA');
            $Validation['type_seat_id']= $typeSeat[0]->id;

            /* Declaramos las clases a utilizar */
            $auxiliarys = $this->auxiliarySeatRepository->getModel();
            /* Validamos los datos para guardar tabla menu */
            if ($auxiliarys->isValid($Validation)):
                $auxiliarys->fill($Validation);
                $auxiliarys->save();

                $total = $this->auxiliarySeatRepository->getModel()->where('code',$auxiliarys->code)->where('type_seat_id',$auxiliarys->type_seat_id)->groupBy('code')->sum('amount');
                return $this->exito(['token'=>$Validation['token'],'id'=>$auxiliarys->id,'total'=>$total]);
            endif;
            /* Enviamos el mensaje de error */
            return $this->errores($auxiliarys->errors);
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('auxiliarySeat Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }

    /**
     * @param $student
     * @param $amount
     * @param $message
     * @param $type
     * @param $collection
     * @return mixed
     */
    public function saveMatricula($student,$amount,$message,$type,$collection,$token)
    {
        try{
            $typeSeat=$this->typeSeatRepository->whereDuoData('DGA');
            $Validation = $this->generationSeat($student,$typeSeat,$amount,$message,$type,$collection,$token);
            //    echo json_encode($Validation); die;
            /* Declaramos las clases a utilizar */
            $auxiliarys = $this->auxiliarySeatRepository->getModel();
            /* Validamos los datos para guardar tabla menu */
            if ($auxiliarys->isValid($Validation)):
                $auxiliarys->fill($Validation);
                $auxiliarys->save();

                return $this->exito('Se guardo con exito');
            endif;
            /* Enviamos el mensaje de error */
            return $this->errores($auxiliarys->errors);
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('auxiliarySeat Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }
    /**
     * @param $student
     * @param $typeSeat
     * @param $amount
     * @param $message
     * @param $type
     * @param $collection
     * @return array
     */
    public function generationSeat($student,$typeSeat,$amount,$message,$type,$collection,$token){
        $seat=   ['date'=>dateShort(),
            'code'=>$typeSeat[0]->abbreviation(),
            'detail'=>$message.' del mes '.changeLetterMonth(periodSchool()->month),
            'amount'=>$amount,
            'financial_records_id'=>$student->id,
            'type_seat_id'=>$typeSeat[0]->id,
            'accounting_period_id'=>periodSchool()->id,
            'type_id'=>$this->typeFormRepository->nameType($type),
            'token'=>$token,
            'status'=>'aplicado',
            'typeCollection'=>$collection,
            'user_created' => Auth::user()->id
        ];
        return $seat;
    }
    public function generationOtherSeat($student,$typeSeat,$amount,$message,$type,$collection,$period,$token){
        $seat=   ['date'=>dateShort(),
            'code'=>$typeSeat[0]->abbreviation(),
            'detail'=>$message.' del mes '.changeLetterMonth($period->month),
            'amount'=>$amount,
            'financial_records_id'=>$student->id,
            'type_seat_id'=>$typeSeat[0]->id,
            'accounting_period_id'=>periodSchool()->id,
            'type_id'=>$this->typeFormRepository->nameType($type),
            'token'=>$token,
            'status'=>'aplicado',
            'typeCollection'=>$collection,
            'user_created' => Auth::user()->id
        ];
        return $seat;
    }
    /**
     * @param $message
     * @param $period
     * @return mixed
     */
    public function registerDataFinantial($message,$period){
        $Students = $this->studentRepository->listsWhere('school_id',userSchool()->id,'id');
        $typeSeat=$this->typeSeatRepository->whereDuoData('DGA');
        $token =Crypt::encrypt($typeSeat[0]->abbreviation());
        foreach($Students AS $Student):
            #
            $newStudent = $this->financialRecordsRepository->getModel()->where('student_id',$Student)->where('year',periodSchool()->year)->get();
            $temp = $this->auxiliarySeatRepository->getModel()->where('financial_records_id',$newStudent[0]->id)->where('typeCollection','matricula')->get();
            $this->financialRecordsRepository->updateData($newStudent[0]->id,'status','aplicado');
            if($temp->isEmpty()):
                // echo json_encode($newStudent[0]->monthly_discount); die;
                $matricula= $this->saveMatricula($newStudent[0],$newStudent[0]->costs->tuition,$message.'la Matricula ','DEBITO','matricula',$token);
                if(!$matricula):
                    DB::rollback();
                    return $this->errores(['AuxiliarySeat' =>'No se pudo guardar los datos.']);
                endif;
                if($newStudent[0]->tuition_discount>0):
                    $this->saveMatricula($newStudent[0],$newStudent[0]->tuition_discount,$message.'del Descuento por Matricula ','CREDITO','descuento',$token);
                endif;

            endif;
        endforeach;
        $this->typeSeatRepository->updateWhere('DGA');
    }
    /**
     * @param $token
     * @return \Illuminate\View\View
     */
    public function view($token){
        $auxiliarySeats   = $this->auxiliarySeatRepository->whereId('token',$token,'id');
        
        $total = $this->auxiliarySeatRepository->getModel()->where('code',$auxiliarySeats[0]->code)->where('type_seat_id',$auxiliarySeats[0]->type_seat_id)->sum('amount');
        return View('auxiliarySeats.view', compact('auxiliarySeats','total'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function status()
    {
        try {
            $token = $this->convertionObjeto();
            DB::beginTransaction();
            $balance=$this->updateBalance($token->token);
            $auxiliary = $this->auxiliarySeatRepository->updateWhere($token->token, 'aplicado', 'status');
           if ($auxiliary > 0):
                $this->typeSeatRepository->updateWhere('DGA');
                DB::commit();
                return $this->exito("Se ha aplicado con exito!!!");
            endif;
            DB::rollback();
            return $this->errores('No se puedo Aplicar el asiento, si persiste contacte soporte');
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('auxiliarySeat Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }
    /**
     * @param $token
     */
    public function updateBalance($token){
        $seats = $this->auxiliarySeatRepository->getModel()->where('token',$token)->get();
        foreach($seats AS $seat):
            $student = $this->financialRecordsRepository->saldoStudent($seat->financial_records_id);

            if($seat->types->name=='DEBITO'):
                $balance = $seat->amount + $student;
                $this->financialRecordsRepository->updateData($seat->financial_records_id,'balance',$balance);
            else:
                $balance =  $student - $seat->amount;
                $this->financialRecordsRepository->updateData($seat->financial_records_id,'balance',$balance);
            endif;

        endforeach;
        DB::commit();
        return $this->exito("se actualizo los saldos con exito");
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteDetail($id)
    {
        $auxiliary= $this->auxiliarySeatRepository->destroy($id);
        if($auxiliary==1):
            $typeSeat = $this->typeSeatRepository->whereDuoData('DGA');
            $auxiliarySeats   = $this->auxiliarySeatRepository->whereDuo('status','no aplicado','type_seat_id',$typeSeat[0]->id,'id','ASC');
            $total=0;
            if(!$auxiliarySeats->isEmpty()):
                $total = $this->auxiliarySeatRepository->getModel()->where('code',$auxiliarySeats[0]->code)->where('type_seat_id',$typeSeat[0]->id)->groupBy('code')->sum('amount');
            endif;
            return $this->exito(['total'=>$total, 'message' => 'Se ha eliminado con éxito']);
        endif;
        return $this->errores('No se puedo eliminar la fila, si persiste contacte soporte');
    }

    /**
     * @param $student
     * @param $amount
     * @param $message
     * @param $type
     * @param $collection
     * @return mixed
     */
    public function saveMensualidad($student,$amount,$message,$type,$collection,$period,$token)
    {
        try{
            $typeSeat=$this->typeSeatRepository->whereDuoData('DGA');
            $Validation = $this->generationOtherSeat($student,$typeSeat,$amount,$message,$type,$collection,$period,$token);
            //    echo json_encode($Validation); die;
            /* Declaramos las clases a utilizar */
            $auxiliarys = $this->auxiliarySeatRepository->getModel();
            /* Validamos los datos para guardar tabla menu */
            if ($auxiliarys->isValid($Validation)):
                $auxiliarys->fill($Validation);
                $auxiliarys->save();

                return $this->exito('Se guardo con exito');
            endif;
            /* Enviamos el mensaje de error */
            return $this->errores($auxiliarys->errors);
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('auxiliarySeat Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }

    /**
     * @return mixed
     */
    public function other(){
        $period = $this->convertionObjeto();
        $periods= explode('/',$period->dateOther);
        $idPeriod= $this->accountingPeriodRepository->getModel()->where('month',$periods[0])->where('year',$periods[1])->where('school_id',userSchool()->id)->get();
        $Students = $this->studentRepository->listsWhere('school_id',userSchool()->id,'id');
        # buscamos el code para generar el token para el asiento
        $typeSeat=$this->typeSeatRepository->whereDuoData('DGA');
        $token =Crypt::encrypt($typeSeat[0]->abbreviation());
        foreach($Students AS $Student):
            $newStudent = $this->financialRecordsRepository->getModel()->where('student_id',$Student)->where('year',periodSchool()->year)->get();
            $temp = $this->auxiliarySeatRepository->getModel()->where('financial_records_id',$newStudent[0]->id)->where('typeCollection','mensualidad')->get();
            if($temp->isEmpty()):
                $mensualidad= $this->saveMensualidad($newStudent[0],$newStudent[0]->costs->tuition,'Registro de la mensualidad ','DEBITO','mensualidad',$idPeriod[0],$token);
                $this->tempAuxiliarySeatController->saveMatricula($newStudent[0],$newStudent[0]->costs->monthly_payment,'Registro de la Mensualidad del','DEBITO',$idPeriod[0],$token);
                if(!$mensualidad):
                    DB::rollback();
                    return $this->errores(['AuxiliarySeat' =>'No se pudo guardar los datos.']);
                endif;
                if($newStudent[0]->tuition_discount>0):
                    $this->saveMensualidad($newStudent[0],$newStudent[0]->tuition_discount,'Registro del Descuento por Matricula ','CREDITO','descuento',$idPeriod[0],$token);
                endif;

            endif;
        endforeach;
        # Actualizamos los saldos de los estudiantes
        $this->updateBalance($token);
        $this->typeSeatRepository->updateWhere('DGA');
        return $this->exito('Se registro con exito!!!.');
    }
    /**
     * 
     * @param type $idFinantial
     * @param type $period
     * @return type
     */
    public function SaldoStudent($idFinantial, $period){
       $type = $this->typeFormRepository->nameType('DEBITO');
      $debito =  $this->auxiliarySeatRepository->saldoStudentPeriod($idFinantial, $period, $type);
      $type = $this->typeFormRepository->nameType('CREDITO');
      $credito =  $this->auxiliarySeatRepository->saldoStudentPeriod($idFinantial, $period, $type);
     
      $saldo = $debito-$credito;
      return $saldo;
    }
}
