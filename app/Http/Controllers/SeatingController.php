<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Entities\Seating;
use AccountHon\Entities\TypeForm;
use AccountHon\Repositories\CatalogRepository;
use AccountHon\Repositories\AccountingPeriodRepository;
use AccountHon\Repositories\SeatingPartRepository;
use AccountHon\Repositories\SeatingRepository;
use AccountHon\Repositories\TypeFormRepository;
use AccountHon\Repositories\TypeSeatRepository;
use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SeatingController extends Controller
{
    /**
     * @var SeatingRepository
     */
    protected $seatingRepository;
    /**
     * @var TypeFormRepository
     */
    protected $typeFormRepository;
    /**
     * @var CatalogRepository
     */
    protected $catalogRepository;
    /**
     * @var TypeSeatRepository
     */
    protected $typeSeatRepository;

    /**
     * @var AccountingPeriodRepository
     */
    protected $accountingPeriodRepository;
    /**
     * @var SeatingPartRepository
     */
    private $seatingPartRepository;


    /**
     * @param SeatingRepository $seatingRepository
     * @param TypeFormRepository $typeFormRepository
     * @param CatalogRepository $catalogRepository
     * @param TypeSeatRepository $typeSeatRepository
     * @param PeriodsRepository $periodsRepository
     */
    public function __construct(
        SeatingRepository $seatingRepository,
        TypeFormRepository $typeFormRepository,
        CatalogRepository $catalogRepository,
        TypeSeatRepository $typeSeatRepository,
        AccountingPeriodRepository $accountingPeriodRepository,
        SeatingPartRepository $seatingPartRepository

    ){

        $this->seatingRepository = $seatingRepository;
        $this->typeFormRepository = $typeFormRepository;
        $this->catalogRepository = $catalogRepository;
        $this->typeSeatRepository = $typeSeatRepository;


        $this->accountingPeriodRepository = $accountingPeriodRepository;
        $this->seatingPartRepository = $seatingPartRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $typeSeat = $this->typeSeatRepository->whereDuoData('DG');
        if($typeSeat->isEmpty()):
            Log::warning('No existe tipo de asiento DG: en la institucion '.userSchool()->name);
            abort(500,'prueba');
        endif;
        $seatings = $this->seatingRepository->whereDuo('status','aplicado','type_seat_id',$typeSeat[0]->id,'id','ASC');
        $seatingsParts = $this->seatingPartRepository->whereDuo('status','aplicado','type_seat_id',$typeSeat[0]->id,'id','ASC');
        return View('seatings.index', compact('seatings', 'seatingsParts'));
    }

    public function view($token){
        $seatings      = $this->seatingRepository->whereId('token',$token,'id');
        $seatingsParts = $this->seatingPartRepository->whereId('token', $token, 'id');
        $total         = $this->seatingRepository->getModel()->where('code',$seatings[0]->code)->where('type_seat_id', $seatings[0]->type_seat_id)->sum('amount');
        return View('seatings.view', compact('seatings','seatingsParts','total'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if(periodSchool()):
            $types    = $this->typeFormRepository->getModel()->all();
            $typeSeat = $this->typeSeatRepository->whereDuoData('DG');
            /**pendiente solo debe enviar los estudiantes de la institucion*/
            $catalogs = $this->catalogRepository->whereDuo('school_id',userSchool()->id,'style','Detalle','code','ASC');
            $seatings='';
            $seatingsParts='';
            if(!$typeSeat->isEmpty()):
                $seatings   = $this->seatingRepository->whereDuo('status','no aplicado','type_seat_id',$typeSeat[0]->id,'id','ASC');
            endif;
           if(!$seatings->isEmpty()):
                $seatingsParts = $this->seatingPartRepository->whereId('code',$seatings[0]->code, 'id');
                $total = $this->seatingRepository->getModel()->where('code',$seatings[0]->code)->where('type_seat_id',$typeSeat[0]->id)->groupBy('code')->sum('amount');
            endif;
            return View('seatings.create', compact('types','typeSeat','catalogs','seatings','seatingsParts','total'));
        endif;
        return $this->errores('No tiene periodos contables Creados');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try{
            $seatings= $this->convertionObjeto();
            
            $verification=$this->seatingRepository->getModel()->where('code',$seatings->codeSeating)->where('accounting_period_id',$seatings->accoutingPeriodSeating)->get();
            $Validation = $this->CreacionArray($seatings, 'Seating');
            if(count($verification)>0):
                $Validation['token']= $verification[0]->token;
            endif;

            foreach ($Validation['accountPart'] as $key => $accountPart) {
                if($Validation['account'] == $accountPart):
                    return $this->errores(['error' => 'Las cuentas no puede ser iguales']);
                endif;
                if(!($Validation['amount'][$key] > 0)){
                    return $this->errores(['error' => 'El monto debe ser mayor 0.']);
                }
            }
            //unset($Validation['accountPart']);

            $amount=0;
            foreach ($Validation['amount'] as $amountArr) {
                $amount += $amountArr;
            }
            $Validation['amount'] = $amount;
            
            $data= $this->createArray($Validation,$verification);
            //echo json_encode($data);die;

            /* Declaramos las clases a utilizar */
            $seating = $this->seatingRepository->getModel();
            /* Validamos los datos para guardar tabla menu */
            DB::beginTransaction();
            if ($seating->isValid($data)):
                $seating->fill($data);
                if( $seating->save() ){
                    if($this->seatingPart($seatings,$seating)){
                        DB::commit();
                        $total = $this->seatingRepository->getModel()->where('token', $seating->token)->sum('amount');
                        return $this->exito(['id' => $seating->id, 'total' => $total, 'token' => $seating->token]);
                    }else{
                        DB::rollback();
                        \Log::error("error en la clase: ".__CLASS__." método ".__METHOD__." - seatingPart.");
                        return $this->errores(['errorSave' => 'No se ha podido grabar el asiento.']);
                    }
                }else{
                    \Log::error("error en la clase: ".__CLASS__." método ".__METHOD__." - store.");
                    return $this->errores(['errorSave' => 'No se ha podido grabar el asiento.']);        
                }
            endif;
            DB::rollback();
            /* Enviamos el mensaje de error */
            return $this->errores($seating->errors);
        }catch (Exception $e) {
            Db::rollback();
            \Log::error($e);
            return $this->errores(array('auxiliarySeat Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }
    public function seatingPart($seatings, $seatingParent)
    {

        $type_id_child = $this->typeFormRepository->whereNot('id', $seatingParent->type_id);

        try{
            $seating = [
                'code'                 => $seatingParent->code,
                'detail'               => $seatingParent->detail,
                'date'                 => $seatingParent->date,
                'amount'               => 0,
                'status'               => 'no aplicado',
                'catalog_id'           => '',
                'seating_id'           => $seatingParent->id,
                'accounting_period_id' => $seatingParent->accounting_period_id,
                'type_id'              => $type_id_child[0]->id,
                'type_seat_id'         => $seatingParent->type_seat_id,
                'token'                => $seatingParent->token,
                'user_created'         => Auth::user()->id
            ];

            for( $i=0; $i < count($seatings->amountSeating); $i++):
                $amount                = $seatings->amountSeating[$i];
                $seating['amount']     = $amount;
                $seating['catalog_id'] = $this->catalogRepository->token($seatings->accountPartSeating[$i])->id;
                
                $seatingChild = $this->seatingPartRepository->getModel();
                if ($seatingChild->isValid($seating)):
                    $seatingChild->fill($seating);
                    if( !$seatingChild->save() ){
                        return false;
                    }
                endif;
            endfor;
            return true;
        }catch (Exception $e) {
            \Log::error($e);
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
        $period = $this->accountingPeriodRepository->token($Validation['accoutingPeriod']);
        unset($Validation['accoutingPeriod']);
        $Validation['accounting_period_id']=$period->id;
        $Validation['status'] = 'no aplicado';
        $Validation['user_created'] = Auth::user()->id;


        return $Validation;
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
            $seating = $this->seatingRepository->updateWhere($token->token, 'aplicado', 'status');
          
            if ($seating > 0):
                if($this->seatingPartRepository->updateWhere($token->token, 'aplicado', 'status') > 0){
                    if($this->typeSeatRepository->updateWhere('DG', userSchool()->id) > 0){
                        DB::commit();
                        return $this->exito("Se ha aplicado con exito!!!");
                    }
                    DB::rollback();
                    return $this->errores('No se puedo Aplicar el asiento, si persiste contacte soporte');
                }else{
                    DB::rollback();
                    return $this->errores('No se puedo Aplicar el asiento, si persiste contacte soporte');
                }
            endif;
            DB::rollback();
            return $this->errores('No se puedo Aplicar el asiento, si persiste contacte soporte');
        }catch (Exception $e) {
            DB::rollback();
            \Log::error($e);
            return $this->errores(array('auxiliarySeat Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteDetail($id)
    {
        try {
            DB::beginTransaction();
            $this->seatingPartRepository->getModel()->where('seating_id', $id)->delete();
            $seating = $this->seatingRepository->getModel()->where('id', $id)->delete();
            if ($seating == 1):
                $typeSeat = $this->typeSeatRepository->whereDuoData('DG');
                $seatings = $this->seatingRepository->whereDuo('status', 'no aplicado', 'type_seat_id', $typeSeat[0]->id,'id','ASC');
                $total = 0;
                if (!$seatings->isEmpty()):
                    $total = $this->seatingRepository->getModel()->where('code', $seatings[0]->code)->groupBy('code')->sum('amount');
                endif;
                DB::commit();
                return $this->exito(['total' => $total, 'message' => 'Se ha eliminado con éxito']);
            endif;
            DB::rollback();
            return $this->errores('No se puedo eliminar la fila, si persiste contacte soporte');
        }catch (Exception $e) {
            DB::rollback();
            \Log::error($e);
            return $this->errores(array('auxiliarySeat Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }



}
