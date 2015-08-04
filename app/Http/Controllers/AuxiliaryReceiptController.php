<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Repositories\AuxiliaryReceiptRepository;
use AccountHon\Repositories\CashRepository;
use AccountHon\Repositories\DepositRepository;
use AccountHon\Repositories\FinancialRecordsRepository;
use AccountHon\Repositories\StudentRepository;
use AccountHon\Repositories\TypeFormRepository;
use AccountHon\Repositories\TypeSeatRepository;
use AccountHon\Repositories\SchoolsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Crypt;
use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class AuxiliaryReceiptController extends Controller
{
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
     * @var AuxiliaryReceiptRepository
     */
    private $auxiliaryReceiptRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var DepositRepository
     */
    private $depositRepository;
    /**
     * @var CashRepository
     */
    private $cashRepository;
    /**
     * @var SchoolsRepository
     */
    private $schoolsRepository;

    /**
     * @param TypeFormRepository $typeFormRepository
     * @param TypeSeatRepository $typeSeatRepository
     * @param FinancialRecordsRepository $financialRecordsRepository
     * @param AuxiliaryReceiptRepository $auxiliaryReceiptRepository
     * @param StudentRepository $studentRepository
     * @param DepositRepository $depositRepository
     * @param CashRepository $cashRepository
     * @param SchoolsRepository $schoolsRepository
     */
    public function __construct(
        TypeFormRepository $typeFormRepository,
        TypeSeatRepository $typeSeatRepository,
        FinancialRecordsRepository $financialRecordsRepository,
        AuxiliaryReceiptRepository $auxiliaryReceiptRepository,
        StudentRepository $studentRepository,
        DepositRepository $depositRepository,
        CashRepository $cashRepository,
        SchoolsRepository $schoolsRepository
    ){
        $this->middleware('auth');

        $this->typeFormRepository = $typeFormRepository;
        $this->typeSeatRepository = $typeSeatRepository;
        $this->financialRecordsRepository = $financialRecordsRepository;
        $this->auxiliaryReceiptRepository = $auxiliaryReceiptRepository;
        $this->studentRepository = $studentRepository;
        $this->depositRepository = $depositRepository;
        $this->cashRepository = $cashRepository;
        $this->schoolsRepository = $schoolsRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $schools_ids          = $this->studentRepository->lists('id');
        $financialRecords_ids = $this->financialRecordsRepository->whereInList('student_id', $schools_ids, 'id');
        $auxiliaryReceipts    = $this->auxiliaryReceiptRepository->whereIn('status', 'aplicado','financial_record_id', $financialRecords_ids);
        return View('auxiliaryReceipts.index', compact('auxiliaryReceipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $types = $this->typeFormRepository->getModel()->all();
        $typeSeat= $this->typeSeatRepository->whereDuoData('RCA');
        if($typeSeat->isEmpty()):
            abort(503);
        endif;
        $auxiliaryReceipts   = $this->auxiliaryReceiptRepository->whereDuo('status','no aplicado','type_seat_id',$typeSeat[0]->id,'id','ASC');
        /**pendiente solo debe enviar los estudiantes de la institucion*/
        if(!$auxiliaryReceipts->isEmpty()):
            $total = $this->auxiliaryReceiptRepository->getModel()->where('type_seat_id',$typeSeat[0]->id)->where('receipt_number',$auxiliaryReceipts[0]->receipt_number)->sum('amount');
        endif;
        $financialRecords = $this->financialRecordsRepository->whereId('year',periodSchool()->year,'year');
        return View('auxiliaryReceipts.create', compact('types','typeSeat','financialRecords','auxiliaryReceipts','total'));
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
            $verification=$this->auxiliaryReceiptRepository->whereId('receipt_number',$auxiliary->receiptNumberAuxiliaryReceipt,'updated_at');

            if(!$verification->isEmpty()):
                if (count($verification) == 5):
                    return $this->errores(['message'=>'Solo se permiten 5 movimientos por recibos']);
                endif;
            endif;

            $Validation = $this->CreacionArray($auxiliary, 'AuxiliaryReceipt');
            $Validation['line']= 1;
            if($verification->count()>0):
                $Validation['token']= $verification[0]->token;
                $Validation['date']= $verification[0]->date;
                $Validation['line']= $verification[0]->line+1;
            endif;
            $type=$this->typeFormRepository->whereId('name','Credito','id');
            $Validation['type_id']= $type[0]->id;
            /* Creamos un array para cambiar nombres de parametros */
            $Validation['user_created'] = Auth::user()->id;
            $student = $this->studentRepository->token($Validation['financialRecord']);
            $Validation['financial_record_id'] = $student->financialRecords->id;
            $Validation['status'] = 'no aplicado';
            $Validation['receipt_number'] = $Validation['receiptNumber'];
            $Validation['received_from'] = $Validation['receivedFrom'];
            $Validation['accounting_period_id']= periodSchool()->id;
            $typeSeat=$this->typeSeatRepository->whereDuoData('RCA');
            $Validation['type_seat_id']= $typeSeat[0]->id;

            /* Declaramos las clases a utilizar */
            $auxiliarys = $this->auxiliaryReceiptRepository->getModel();
            /* Validamos los datos para guardar tabla menu */
            if ($auxiliarys->isValid($Validation)):
                $auxiliarys->fill($Validation);
                $auxiliarys->save();

                $total = $this->auxiliaryReceiptRepository->getModel()->where('receipt_number',$auxiliarys->receipt_number)->sum('amount');
                return $this->exito(['token'=>$Validation['token'],'id'=>$auxiliarys->id,'total'=>$total]);
            endif;
            /* Enviamos el mensaje de error */
            return $this->errores($auxiliarys->errors);
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('auxiliaryReceipt Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Response
     * @internal param int $id
     */
    public function status()
    {
        try{
            $deposits = $this->convertionObjeto();

            $auxiliaryReceipt= $this->auxiliaryReceiptRepository->token($deposits->token);

            //array depositos validos
            $deposits_valids = array();

            $sumDeposit=0;

            //Validando el total
            $total = $this->auxiliaryReceiptRepository->getModel()->where('receipt_number',$auxiliaryReceipt->receipt_number)->sum('amount');

            if( $deposits->numberDepositAuxiliaryReceipt[0] != null || $deposits->numberDepositAuxiliaryReceipt[0] != '' ){
                //Validación de datos
                for($i=0;$i<count($deposits->numberDepositAuxiliaryReceipt);$i++):
                    $validation = array('number'=>$deposits->numberDepositAuxiliaryReceipt[$i],
                        'date'=>$deposits->dateDepositAuxiliaryReceipt[$i],
                        'account'=>$deposits->accountDepositAuxiliaryReceipt[$i],
                        'amount'=>$deposits->amountDepositAuxiliaryReceipt[$i],
                        'school_id'=>userSchool()->id,
                        'token'=>Crypt::encrypt($deposits->numberDepositAuxiliaryReceipt[$i]),
                        'codeReceipt'=>$auxiliaryReceipt->receipt_number
                    );
                    $deposit = $this->depositRepository->getModel();

                    if($deposit->isValid($validation)):
                        array_push($deposits_valids, $validation);
                    else:
                        return $this->errores($deposit->errors);
                    endif;
                endfor;

                //validate date and number
                if( !$this->validateDeposits($deposits) ){
                    return $this->errores('No se pueden registrar los datos, existen depósitos duplicados.');
                }
                foreach($deposits->amountDepositAuxiliaryReceipt AS $suma):
                    $sumDeposit += $suma;
                endforeach;

                if($total < $sumDeposit):
                    return $this->errores(array('auxiliaryReceipt Save' => 'Los depositos no pueden ser de mayor cantidad que el recibo'));
                endif;

                DB::beginTransaction();
                foreach ($deposits_valids as $key => $value) {
                    $deposit = $this->depositRepository->getModel();
                    $deposit->fill($value);
                    if($deposit->save()){
                        $validate = true;
                    }else{
                        $validate = false;
                    }
                }
            }

            if(isset($validate) && !$validate){
                DB::rollback();
                return $this->errores('No se pudieron grabar los depósitos');
            }

            if($total > $sumDeposit):
                $diferent = $total - $sumDeposit;
                $cash     = $this->cashRepository->getModel();
                $cashs    = ['amount'=>$diferent,'receipt'=>$auxiliaryReceipt->receipt_number,'school_id'=>userSchool()->id];
                if($cash->isValid($cashs)):
                    $cash->fill($cashs);
                    if($cash->save()){
                        $validate = true;
                    }else{
                        $validate = false;
                    }
                endif;
            endif;

            if(!$validate){
                DB::rollback();
                Log::error('No se pudo grabar el efectivo '.__CLASS__.', método '.__METHOD__.'.');
                return $this->errores('No se pudo grabar el efectivo');
            }

            if(!$this->updateBalance($deposits->token)){
                DB::rollback();
                Log::error('Error al guardar el balance');
                return $this->errores('No se pudo grabar el Recibo');
            }

            $auxiliary = $this->auxiliaryReceiptRepository->updateWhere($deposits->token,'aplicado','status');
            if($auxiliary>0){
                if( $this->typeSeatRepository->updateWhere('RCA') > 0){
                    DB::commit();
                    return $this->exito("Se ha aplicado con exito!!!");
                }
            }else{
                DB::rollback();
                Log::error('No se puede aplicar el status a aplicado '.__CLASS__.', método '.__METHOD__.'.');
                return $this->errores('No se puede aplicar el asiento, si persiste contacte soporte');
            }
            DB::rollback();
            return $this->errores('No se puedo Aplicar el asiento, si persiste contacte soporte');
        }catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return $this->errores(array('auxiliaryReceipt Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }

    public function updateBalance($token){
        $seats = $this->auxiliaryReceiptRepository->getModel()->where('token',$token)->get();
        foreach($seats AS $seat):
            $student =  $this->financialRecordsRepository->saldoStudent($seat->financial_record_id);
            $balance =  $student - $seat->amount;
            if( $this->financialRecordsRepository->updateData($seat->financial_record_id,'balance',$balance) > 0){
                $validate = true;
            }else{
                $validate = false;
            }
        endforeach;
        return $validate;
    }
    /**
     * [view description]
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function view($token){
        $auxiliaryReceipts = $this->auxiliaryReceiptRepository->whereId('token',$token,'id');
        $deposits = $this->depositRepository->whereId('codeReceipt', $auxiliaryReceipts[0]->receipt_number, 'id');
        $deposits_numbers = '';
        if(!$deposits->isEmpty()){
            foreach ($deposits as $key => $deposit) {
                $deposits_numbers .= $deposit->number.', ';
            }
            $deposits_numbers = substr($deposits_numbers, 0, -2).'.';
        }

        $total = $this->auxiliaryReceiptRepository->getModel()->where('receipt_number',$auxiliaryReceipts[0]->receipt_number)->sum('amount');
        return View('auxiliaryReceipts.view', compact('auxiliaryReceipts','total', 'deposits_numbers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteDetail($id)
    {

        $auxiliary= $this->auxiliaryReceiptRepository->destroy($id);
        if($auxiliary==1):
            $typeSeat = $this->typeSeatRepository->whereDuoData('RCA');
            $auxiliaryReceipts   = $this->auxiliaryReceiptRepository->whereDuo('status','no aplicado','type_seat_id',$typeSeat[0]->id,'id','ASC');
            $total=0;
            if(!$auxiliaryReceipts->isEmpty()):
                $total = $this->auxiliaryReceiptRepository->getModel()->where('receipt_number',$auxiliaryReceipts[0]->receipt_number)->sum('amount');
            endif;
            return $this->exito(['total'=>$total, 'message' => 'Se ha eliminado con éxito']);
        endif;
        return $this->errores(['No se puedo eliminar la fila, si persiste contacte soporte']);
    }

    private function validateDeposits($deposits){
        $date = $deposits->dateDepositAuxiliaryReceipt;
        $ref  = $deposits->numberDepositAuxiliaryReceipt;

        $duplicatesDate = $this->get_keys_for_duplicate_values($date);

        foreach ($duplicatesDate as $key => $position) {
            $auxRef = null;
            foreach ($position as $keyPos => $valuePos) {
                if($ref[$valuePos] == $auxRef){
                    return false;
                }
                $auxRef = $ref[$valuePos];
            }
        }

        return true;
    }

    private function get_keys_for_duplicate_values($my_arr) {
        $duplicates = array_count_values($my_arr);

        $new_array = array();
        foreach ($duplicates as $key => $value) {
            if($value > 1){
                array_push($new_array, $key);
            }
        }

        $dups = array();
        foreach ($my_arr as $keyMy => $valueMy) {
            foreach ($new_array as $key => $value) {
                if($value == $valueMy){
                    if (isset($dups[$valueMy])) {
                        $dups[$valueMy][] = $keyMy;
                    } else {
                        $dups[$valueMy] = array($keyMy);
                    }
                }
            }
        }
        return $dups;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function report($token)
    {
        $dataReceipt = $this->auxiliaryReceiptRepository->allToken($token);
        $totalReceipt = $this->auxiliaryReceiptRepository->sumToken($token);
        $deposits = $this->depositRepository->whereDuo('codeReceipt', $dataReceipt[0]->receipt_number, 'school_id', userSchool()->id,'id','ASC');
        $deposits_numbers = '';
        if(!$deposits->isEmpty()){
            foreach ($deposits as $key => $deposit) {
                $deposits_numbers .= $deposit->number.', ';
            }
            $deposits_numbers = substr($deposits_numbers, 0, -2).'.';
        }
        //return View('auxiliaryReceipts.report',compact('dataReceipt','totalReceipt', 'deposits_numbers'));die;

        $pdf = \PDF::loadView('auxiliaryReceipts.report', compact('dataReceipt','totalReceipt', 'deposits_numbers'))->setOrientation('portrait');

        return $pdf->stream("Impresion - $dataReceipt[0]->receipt_number.pdf");
    }
}
