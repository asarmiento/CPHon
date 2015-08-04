<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Entities\AuxiliarySeat;
use AccountHon\Entities\Degree;
use AccountHon\Repositories\CostRepository;
use AccountHon\Repositories\DegreesRepository;
use AccountHon\Repositories\FinancialRecordsRepository;
use AccountHon\Repositories\StudentRepository;
use AccountHon\Repositories\TempAuxiliarySeatRepository;
use AccountHon\Repositories\TypeSeatRepository;
use Illuminate\Http\Request;
use AccountHon\Entities\Student;
use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * @var DegreesRepository
     */
    private $degreesRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var CostRepository
     */
    private $costRepository;
    /**
     * @var FinancialRecordsRepository
     */
    private $financialRecordsRepository;
    /**
     * @var TypeSeatRepository
     */
    private $typeSeatRepository;
    /**
     * @var FinacialRecordsController
     */
    private $finacialRecordsController;
    /**
     * @var AuxiliarySeatController
     */
    private $auxiliarySeatController;
    /**
     * @var TempAuxiliarySeatController
     */
    private $tempAuxiliarySeatController;
    /**
     * @var TempAuxiliarySeatRepository
     */
    private $tempAuxiliarySeatRepository;

    /**
     * @param StudentRepository $studentRepository
     * @param CostRepository $costRepository
     * @param DegreesRepository $degreesRepository
     * @param FinancialRecordsRepository $financialRecordsRepository
     * @param TypeSeatRepository $typeSeatRepository
     * @param FinacialRecordsController $finacialRecordsController
     * @param AuxiliarySeatController $auxiliarySeatController
     * @param TempAuxiliarySeatController $tempAuxiliarySeatController
     * @param TempAuxiliarySeatRepository $tempAuxiliarySeatRepository
     */
    public function __construct(
        StudentRepository $studentRepository ,
        CostRepository $costRepository,
        DegreesRepository $degreesRepository,
        FinancialRecordsRepository $financialRecordsRepository,
        TypeSeatRepository $typeSeatRepository,
        FinacialRecordsController $finacialRecordsController,
        AuxiliarySeatController $auxiliarySeatController,
        TempAuxiliarySeatController $tempAuxiliarySeatController,
    TempAuxiliarySeatRepository $tempAuxiliarySeatRepository
    ){

        $this->degreesRepository = $degreesRepository;
        $this->studentRepository = $studentRepository;
        $this->costRepository = $costRepository;
        $this->financialRecordsRepository = $financialRecordsRepository;
        $this->typeSeatRepository = $typeSeatRepository;
        $this->finacialRecordsController = $finacialRecordsController;
        $this->auxiliarySeatController = $auxiliarySeatController;
        $this->tempAuxiliarySeatController = $tempAuxiliarySeatController;
        $this->tempAuxiliarySeatRepository = $tempAuxiliarySeatRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $students = $this->studentRepository->whereId('school_id',userSchool()->id,'sex'); // Student::all();
        return View('students.index', compact('students'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function enrolled()
    {
        if(count(periodSchool())>0):
            $finantialRecords = $this->financialRecordsRepository->whereDuo('year',periodSchool()->year,'status','aplicado','id','ASC'); // Student::all();
            return View('students.enrolled', compact('finantialRecords'));
        endif;
        $errorLog = 'No existe Periodo Contable Verificar en enrolled - Institución: '.userSchool()->name.'.';
        $error = 'Necesita registrar un periodo contable';
        $page  = 'Estudiantes';
        $task  = 'Ver Estudiantes Matriculados';
        Log::info($errorLog);
        return view('errors.validate', compact('error', 'page', 'task'));
        //abort(503);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $degrees = $this->degreesRepository->schoolsActive();
        return View('students.create', compact('degrees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FinacialRecordsController $finacialRecordsController
     * @return Response
     */
    public function store()
    {
        $students = $this->convertionObjeto();
        try {
            /* Creamos un array para cambiar nombres de parametros */
            $Validation                 = $this->CreacionArray($students, 'Student');
            $Validation['school_id']    = userSchool()->id;
            $Validation['user_created'] = Auth::user()->id;
            $Validation['book']         = $this->carnet();
            if(!$Validation['book']){
                return $this->errores('Debe crear un tipo de asiento con la abrebiacion alumn para generar el carnet.');
            }
            /* Declaramos las clases a utilizar */
            $Student = $this->studentRepository->getModel();
            /* Validamos los datos para guardar tabla menu */
            DB::beginTransaction();
            if ($Student->isValid($Validation)):
                $Student->fill($Validation);
                $Student->save();
                $financialRecords= $this->finacialRecordsController->save($Validation,$Student);
                if(!$financialRecords):
                    DB::rollback();
                    return $this->errores(['financialRecords' =>'Se necesitan ingresar los costos del grado seleccionado.']);
                endif;
                $this->registerDataFinantial($Student,'DEBITO','CREDITO','Registro ');
                $this->typeSeatRepository->updateWhere('DGA', userSchool()->id);

                DB::commit();
                return $financialRecords;


            endif;
            DB::rollback();
            /* Enviamos el mensaje de error */
            return $this->errores($Student->errors);
        } catch (Exception $e) {
            DB::rollback();
            \Log::error($e);
            return $this->errores(array('Student Save' => 'Verificar la información el Estudiante, sino contactarse con soporte de la applicación'));
        }
    }

    /**
     * @param $Student
     * @return mixed
     */
    public function registerDataFinantial($Student,$debito,$credito,$message){
        #
        $newStudent = $this->financialRecordsRepository->getModel()->where('student_id',$Student->id)->where('year',periodSchool()->year)->get();
       // echo json_encode($newStudent[0]->monthly_discount); die;
        $typeSeat=$this->typeSeatRepository->whereDuoData('DGA');
        $token =Crypt::encrypt($typeSeat[0]->abbreviation());
        # Cobro de mensualidad
        $mensualidad = $this->auxiliarySeatController->saveMatricula($newStudent[0],$newStudent[0]->costs->monthly_payment,$message.'de la Mensualidad ',$debito,'mensualidad',$token);
        # Registro de combro de periodo para verificacion
        if($message=='Registro '):

        $this->tempAuxiliarySeatController->saveMatricula($newStudent[0],$newStudent[0]->costs->monthly_payment,$message.' de la Mensualidad del',$debito,$token);
            endif;
        # comprobacion si tiene descuento
        if($newStudent[0]->monthly_discount > 0):
            $this->auxiliarySeatController->saveMatricula($newStudent[0],$newStudent[0]->monthly_discount,$message.'del Descuento por Mensualidad  ',$credito,'descuento',$token);
            DB::commit();
        endif;
        #
        if(!$mensualidad):
            DB::rollback();
            return $this->errores(['AuxiliarySeat' =>'No se pudo guardar los datos.']);
        endif;
        # Cobro
        $matricula= $this->auxiliarySeatController->saveMatricula($newStudent[0],$newStudent[0]->costs->tuition,$message.'la Matricula ',$debito,'matricula',$token);
        if(!$matricula):
            DB::rollback();
            return $this->errores(['AuxiliarySeat' =>'No se pudo guardar los datos.']);
        endif;
        if($newStudent[0]->tuition_discount>0):
            $this->auxiliarySeatController->saveMatricula($newStudent[0],$newStudent[0]->tuition_discount,$message.'del Descuento por Matricula ',$credito,'descuento',$token);
        endif;
    }

    public function saveEnrolled(){
        try {
            DB::beginTransaction();
            $this->auxiliarySeatController->registerDataFinantial('Registro ', periodSchool());
            DB::commit();
            return $this->exito('Se matricularon a los estudiantes correctamente ' . changeLetterMonth(periodSchool()->month));
        }catch (Exception $e) {
            DB::rollback();
            \Log::error($e);
            return $this->errores(array('Student Save' => 'contactarse con soporte de la applicación'));
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($token)
    {
        $student = $this->studentRepository->token($token);
        $degrees = $this->degreesRepository->schoolsActive();
        return View('students.edit', compact('degrees','student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update()
    {
        try {
            $students = $this->convertionObjeto();

            $verification = $this->studentRepository->token($students->token);
            $Validation = $this->CreacionArray($students, 'Student');
            $Validation['school_id'] = userSchool()->id;
            $Validation['user_updated'] = Auth::user()->id;
            $Validation['book'] = $verification->book;
            $financialRecords = $this->financialRecordsRepository->whereDuo('student_id', $verification->id, 'year', periodSchool()->year);
            if ($students->statusStudent == 'no'):
                /* Creamos un array para cambiar nombres de parametros */
                DB::beginTransaction();
                /* Declaramos las clases a utilizar */
                $Student = $this->studentRepository->token($students->token);
                /* Se genera el asiento de reversion y el asiento del nuevo grado*/
                $this->saveAuxiliarySeat($Validation,$financialRecords,$Student);
                /* Validamos los datos para guardar tabla menu */
                if ($Student->isValid($Validation)):
                    $Student->fill($Validation);
                    $Student->save();
                    $this->finacialRecordsController->update($financialRecords[0]->id, $Validation, $Student);
                    DB::commit();
                    return $this->exito('Los datos se guardaron con exito!!!');
                endif;
                    DB::rollback();
                /* Enviamos el mensaje de error */
                return $this->errores($Student->errors);

            else:
                DB::beginTransaction();
                if ($financialRecords->count() > 0):
                    return $this->errores('El alumnos ya esta Matriculado en el grado: ' . $financialRecords[0]->costs->degreeSchool->degrees->name);
                else:

                    /* Declaramos las clases a utilizar */
                    $Student = $this->studentRepository->token($students->token);
                    /* Validamos los datos para guardar tabla menu */
                    if ($Student->isValid($Validation)):
                        $Student->fill($Validation);
                        $Student->save();
                        $this->finacialRecordsController->save($Validation, $Student);
                        $this->registerDataFinantial($Student);
                        $this->typeSeatRepository->updateWhere('DGA', userSchool()->id);
                        DB::commit();
                        return $this->exito('Los datos se guardaron con exito!!!');
                    endif;
                    DB::rollback();
                    /* Enviamos el mensaje de error */
                    return $this->errores($Student->errors);
                endif;
            endif;
        } catch (Exception $e) {
            DB::rollback();
            \Log::error($e);
            return $this->errores(array('Student Save' => 'Verificar la información el Estudiante, sino contactarse con soporte de la applicación'));
        }
    }

    private function saveAuxiliarySeat($Validation,$financialRecords,$Student){
        $cost = $this->costRepository->idCostDegree($Validation['degree']);
        $costoBefore= $this->costRepository->find($financialRecords[0]->cost_id);
        if(!$cost){
            return false;
        }
        $BalanceBefore = ($costoBefore->monthly_payment + $costoBefore->tuition)-($financialRecords[0]->monthly_discount +$financialRecords[0]->tuition_discount);

        if($financialRecords[0]->cost_id != $cost->id):
            $this->registerDataFinantial($Student,'CREDITO','DEBITO','Reversion ');
            $this->financialRecordsRepository->updateData($financialRecords[0]->id,'cost_id',$cost->id);
            $this->registerDataFinantial($Student,'DEBITO','CREDITO','Registro ');
            $BalanceAfter = ($cost->monthly_payment + $cost->tuition)-($Validation['discount'] +$Validation['discountTuition']);
            $balance =  ($financialRecords[0]->balance - $BalanceBefore) + $BalanceAfter;
            $this->financialRecordsRepository->updateData($financialRecords[0]->id,'balance',$balance);
            $this->tempAuxiliarySeatRepository->getModel()->where('financial_records_id',$financialRecords[0]->id)
                ->where('period',periodSchool()->period)->update(['amount'=>$cost->monthly_payment]);
            $this->typeSeatRepository->updateWhere('DGA', userSchool()->id);

        endif;
    }
      /**
     * @return string
     */
    public function carnet()
    {

        $alumno = $this->typeSeatRepository->whereDuoData('alumn');

        if($alumno->isEmpty()):
            return false;
        endif;

        /** @var TYPE_NAME $numero */
        $numero = $alumno[0]->quatity;
        $year = substr($alumno[0]->year,2,2);
        if($numero <= 9)
        {
            $carnet=$year."-0000".$numero;
        }
        elseif(($numero >= 10)&&($numero <= 99))
        {
            $carnet=$year."-000".$numero;
        }
        elseif(($numero >= 100)&&($numero <= 999))
        {
            $carnet=$year."-00".$numero;
        }
        elseif(($numero >= 1000)&&($numero <= 9999))
        {
            $carnet=$year."-0".$numero;
        }
        elseif(($numero >= 10000))
        {
            $carnet=$year."-".$numero;
        }


        return $carnet;
    }
}
