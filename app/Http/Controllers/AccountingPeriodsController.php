<?php

namespace AccountHon\Http\Controllers;

use Illuminate\Http\Request;
use AccountHon\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class AccountingPeriodsController extends BaseAbtractController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $accountingPeriods = $this->accountingPeriodRepository->whereId('school_id', userSchool()->id, 'id');
        return view('accountingPeriods.index', compact('accountingPeriods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $nextPeriod = periodSchool();
        //echo $nextPeriod->month;die;
        if ($nextPeriod->month == 12) {
            $nextPeriod = '01' . '-' . ($nextPeriod->year + 1);
        } else {
            $nextPeriod = ($nextPeriod->month + 1) . '-' . $nextPeriod->year;
        }
        return view('accountingPeriods.create', compact('nextPeriod'));
    }

    /**
     * Store a newly created resource in storage.
     * Pasos para cambio de periodo. 1 en 
     * 1. Preparamos las variables de mes y año para ingresar a la tabla.
     * 2. Preparacion de array que se ingresara la informacion a la tabla de periodos
     * 3. Verificacion de la tabla asientos que no vean datos por aplicar.
     * 4. Verificacion de la tabla asientosPart que no vean datos por aplicar.
     * 5. Verificacion de la tabla recibos contabilidad que no vean datos por aplicar.
     * 6. Verificacion de la tabla recibos contabilidad que no vean datos por aplicar.
     * 7. Verificacion de la tabla asientos de auxiliar que no vean datos por aplicar.
     * 8. Traslado de saldos de saldo de la tabla asientos y asientosPart a la tabla balance
     * 9. Insertar el nuevo periodo para la institucion a la que esta trabajando.
     * 10. Despues de crear el periodo creamos el asiento del nuevo periodo de los alumnos
     * @return Response
     */
    public function store() {
        set_time_limit(0);
        /* Capturamos los datos enviados por ajax */
        $period = $this->convertionObjeto();
        $periodo= periodSchool();
        try {
            $clave = bcrypt($period->clave);
            # Paso 1
            $period = periodSchool();
            if ($period->month == 12) {
                $nextMonth = 1;
                $nextYear = $period->year + 1;
            } else {
                $nextMonth = str_pad($period->month + 1, 2, '0', STR_PAD_LEFT);
                $nextYear = $period->year;
            }
            # Paso 2
            $Validation = array('month' => $nextMonth, 'year' => $nextYear, 'school_id' => userSchool()->id, 'token' => bcrypt($nextYear . $nextMonth), 'period' => $nextYear . $nextMonth, 'user_created' => currentUser()->id);
            /* Declaramos las clases a utilizar */
            DB::beginTransaction();
            # Paso 3
            $seating = $this->seatingRepository->whereDuo('status', 'No Aplicado', 'accounting_period_id', periodSchool()->id,'id','ASC');
            if(!$seating->isEmpty()):
                DB::rollback();
                return $this->errores(array('seating' => 'Existen Asientos pendientes de aplicar'));
            endif;
            # Paso 4
            $seatingPart = $this->seatingPartRepository->whereDuo('status', 'No Aplicado', 'accounting_period_id', periodSchool()->id,'id','ASC');
            if(!$seatingPart->isEmpty()):
                DB::rollback();
                return $this->errores(array('seatingPart' => 'Existen Asientos pendientes de aplicar'));
            endif;
            # Paso 5
            $Receipt = $this->receiptRepository->whereDuo('status', 'No Aplicado', 'accounting_period_id', periodSchool()->id,'id','ASC');
            if(!$Receipt->isEmpty()):
                DB::rollback();
                return $this->errores(array('receipt' => 'Existen Recibos en contabilidad pendientes de aplicar'));
            endif;
            # Paso 6
            $auxiliaryReceipt = $this->auxiliaryReceiptRepository->whereDuo('status', 'No Aplicado', 'accounting_period_id', periodSchool()->id,'id','ASC');
            if(!$auxiliaryReceipt->isEmpty()):
                DB::rollback();
                return $this->errores(array('auxiliaryReceipt' => 'Existen Recibos del auxiliar pendientes de aplicar'));
            endif;
            # Paso 7
            $auxiliarySeat = $this->auxiliarySeatRepository->whereDuo('status', 'No Aplicado', 'accounting_period_id', periodSchool()->id,'id','ASC');
            if(!$auxiliarySeat->isEmpty()):
                DB::rollback();
                return $this->errores(array('auxiliaryReceipt' => 'Existen Asientos del auxiliar pendientes de aplicar'));
            endif;
            # Paso 8
            $this->trasldoSaldo();
            # Paso 9
            $periods = $this->accountingPeriodRepository->getModel();
            /* Validamos los datos para guardar tabla menu */
            if ($periods->isValid($Validation)):
                $periods->fill($Validation);
                $periods->save();
                # Paso 10
                $this->registerDataFinantial('DEBITO', 'CREDITO', 'Registro ', $periods,$periodo);

                DB::commit();
                /* Enviamos el mensaje de guardado correctamente */
                return $this->exito('Los datos se guardaron con exito!!!');
            endif;
            DB::rollback();
            /* Enviamos el mensaje de error */
            return $this->errores($periods->errors);
        } catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('accountingPeriod Save' => 'Verificar la información del asiento, sino contactarse con soporte de la applicación'));
        }
    }

    /**
     * @param $Student
     * @return mixed
     */
    public function registerDataFinantial($debito, $credito, $message, $period,$periodo) {
        $Students = $this->studentRepository->listsWhere('school_id', userSchool()->id, 'id');
       
        if (!$Students->isEmpty()):
            $token = Crypt::encrypt($Students);
            foreach ($Students AS $Student):
                #
                $newStudent = $this->financialRecordsRepository->getModel()->where('student_id', $Student)->where('year', periodSchool()->year)->get();
                 
                $movimiento = $this->auxiliarySeatController->SaldoStudent($newStudent[0]->id, $periodo->id);
                $balance=$newStudent[0]->balance+$movimiento;
                $this->financialRecordsRepository->updateData($newStudent[0]->id, 'balance', $balance);
                $temp = $this->tempAuxiliarySeatRepository->getModel()->where('financial_records_id', $newStudent[0]->id)->where('period', $period->period)->get();
                if ($temp->isEmpty()):
                    # Cobro de mensualidad
                    $mensualidad = $this->auxiliarySeatController->saveMensualidad($newStudent[0], $newStudent[0]->costs->monthly_payment, $message . 'de la Mensualidad ', $debito, 'mensualidad',$period,$token);
                    # Registro de combro de periodo para verificacion
                    if ($message == 'Registro '):
                        $this->tempAuxiliarySeatController->saveMensualidad($newStudent[0], $newStudent[0]->costs->monthly_payment, $message . ' de la Mensualidad del', $debito,$period,$token);
                    endif;
                    # comprobacion si tiene descuento
                    if ($newStudent[0]->monthly_discount > 0):
                        $this->auxiliarySeatController->saveMensualidad($newStudent[0], $newStudent[0]->monthly_discount, $message . 'del Descuento por Mensualidad  ', $credito, 'descuento',$period,$token);
                    endif;
                    #
                    if (!$mensualidad):
                        DB::rollback();
                        return $this->errores(['AuxiliarySeat' => 'No se pudo guardar los datos.']);
                    endif;
                endif;
            endforeach; 
            #Cambiamos el numero de asiento despues de generado los asientos.
            $this->typeSeatRepository->updateWhere('DGA', userSchool()->id);
        endif;
    }

    /**
     * COn esta funcion buscamos los saldos de las cuentas
     * para poder guardarlo en la tabla de balance de periodo
     * mes a mes en cambio de periodo.
     */
    public function trasldoSaldo() {
        $catalogs = $this->catalogRepository->accountSchool();

        foreach ($catalogs AS $catalog):
            $saldo = $this->balancePeriodRepository->saldoTotalPeriod($catalog->id, [periodSchool()->id]);
            $data = ['catalog_id' => $catalog->id, 'amount' => $saldo, 'period' => periodSchool()->period, 'year' => periodSchool()->year, 'school_id' => userSchool()->id];
            $balance = $this->balancePeriodRepository->getModel();
            /* Validamos los datos para guardar tabla menu */
            if ($balance->isValid($data)):
                $balance->fill($data);
                $balance->save();
            /* Enviamos el mensaje de guardado correctamente */
            endif;
        endforeach;
    }

}
