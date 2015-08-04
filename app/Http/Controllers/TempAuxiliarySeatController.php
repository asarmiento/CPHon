<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Repositories\AuxiliarySeatRepository;
use AccountHon\Repositories\TempAuxiliarySeatRepository;
use AccountHon\Repositories\TypeFormRepository;
use AccountHon\Repositories\TypeSeatRepository;
use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TempAuxiliarySeatController extends Controller
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
     * @var AuxiliarySeatRepository
     */
    private $auxiliarySeatRepository;
    /**
     * @var TempAuxiliarySeatRepository
     */
    private $tempAuxiliarySeatRepository;

    /**
     * @param TypeFormRepository $typeFormRepository
     * @param TypeSeatRepository $typeSeatRepository
     * @param AuxiliarySeatRepository $auxiliarySeatRepository
     * @param TempAuxiliarySeatRepository $tempAuxiliarySeatRepository
     */
    public function __construct(
        TypeFormRepository $typeFormRepository,
        TypeSeatRepository $typeSeatRepository,
        AuxiliarySeatRepository $auxiliarySeatRepository,
        TempAuxiliarySeatRepository $tempAuxiliarySeatRepository
    ){

        $this->typeFormRepository = $typeFormRepository;
        $this->typeSeatRepository = $typeSeatRepository;
        $this->auxiliarySeatRepository = $auxiliarySeatRepository;
        $this->tempAuxiliarySeatRepository = $tempAuxiliarySeatRepository;
    }
    public function saveMatricula($student,$amount,$message,$type,$token)
    {
        try{
            $typeSeat=$this->typeSeatRepository->whereDuoData('DGA');
            $Validation = $this->generationSeat($student,$typeSeat,$amount,$message,$type,$token);

            /* Declaramos las clases a utilizar */
            $auxiliarys = $this->tempAuxiliarySeatRepository->getModel();
            /* Validamos los datos para guardar tabla menu */
            if ($auxiliarys->isValid($Validation)):
                $auxiliarys->fill($Validation);
                $auxiliarys->save();

                $total = $this->tempAuxiliarySeatRepository->getModel()->where('code',$auxiliarys->code)->sum('amount');
                return $this->exito(['token'=>$Validation['token'],'id'=>$auxiliarys->id,'total'=>$total]);
            endif;
            /* Enviamos el mensaje de error */
            return $this->errores($auxiliarys->errors);
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('auxiliarySeat Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }
    public function saveMensualidad($student,$amount,$message,$type,$period,$token)
    {
        try{
            $typeSeat=$this->typeSeatRepository->whereDuoData('DGA');
            $Validation = $this->generationOtherSeat($student,$typeSeat,$amount,$message,$type,$period,$token);

            /* Declaramos las clases a utilizar */
            $auxiliarys = $this->tempAuxiliarySeatRepository->getModel();
            /* Validamos los datos para guardar tabla menu */
            if ($auxiliarys->isValid($Validation)):
                $auxiliarys->fill($Validation);
                $auxiliarys->save();

               return $this->exito('Se aplico con exito el asiento');
            endif;
            /* Enviamos el mensaje de error */
            return $this->errores($auxiliarys->errors);
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('auxiliarySeat Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }
    public function generationSeat($student,$typeSeat,$amount,$message,$type,$token){
        $seat=   ['date'=>dateShort(),
            'code'=>$typeSeat[0]->abbreviation(),
            'detail'=>'registro '.$message.' del mes '.changeLetterMonth(periodSchool()->month),
            'amount'=>$amount,
            'financial_records_id'=>$student->id,
            'type_seat_id'=>$typeSeat[0]->id,
            'period'=>periodSchool()->period,
            'type_id'=>$this->typeFormRepository->nameType($type),
            'token'=>$token,
            'status'=>'aplicado',
            'user_created' => Auth::user()->id
        ];
        return $seat;
    }
    public function generationOtherSeat($student,$typeSeat,$amount,$message,$type,$period,$token){
        $seat=   ['date'=>dateShort(),
            'code'=>$typeSeat[0]->abbreviation(),
            'detail'=>'registro '.$message.' del mes '.changeLetterMonth($period->month),
            'amount'=>$amount,
            'financial_records_id'=>$student->id,
            'type_seat_id'=>$typeSeat[0]->id,
            'period'=>$period->period,
            'type_id'=>$this->typeFormRepository->nameType($type),
            'token'=>$token,
            'status'=>'aplicado',
            'user_created' => Auth::user()->id
        ];
        return $seat;
    }
}
