<?php

namespace AccountHon\Http\Controllers;

use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\PaymentFromRepository;
class PaymentFromController extends Controller
{
        private $paymentFromRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(PaymentFromRepository $paymentFromRepository) {
        $this->paymentFromRepository = $paymentFromRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $paymentFroms = $this->paymentFromRepository->withTrashedOrderBy('name', 'ASC');
        return view('paymentFroms.index', compact('paymentFroms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('paymentFroms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $paymentFrom = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($paymentFrom, 'PaymentFrom');
        /* Declaramos las clases a utilizar */
        $paymentFroms = $this->paymentFromRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($paymentFroms->isValid((array) $Validation)):
            $paymentFroms->fill($Validation);
            $paymentFroms->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($paymentFrom->statusPaymentFrom == true):
                $this->paymentFromRepository->withTrashedFind($paymentFroms->id)->restore();
            else:
                $this->paymentFromRepository->destroy($paymentFroms->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($paymentFroms->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $paymentFrom = $this->paymentFromRepository->withTrashedFind($id);

        return view('paymentFroms.edit', compact('paymentFrom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id) {
        /* Capturamos los datos enviados por ajax */
        $paymentFrom = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($paymentFrom, 'PaymentFrom');
        /* Declaramos las clases a utilizar */
        $paymentFroms = $this->paymentFromRepository->withTrashedFind($paymentFrom->idPaymentFrom);
        /* Validamos los datos para guardar tabla menu */
        if ($paymentFroms->isValid((array) $Validation)):
            $paymentFroms->fill($Validation);
            $paymentFroms->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($paymentFrom->statusPaymentFrom == true):
                $this->paymentFromRepository->withTrashedFind($paymentFrom->idPaymentFrom)->restore();
            else:
                $this->paymentFromRepository->destroy($paymentFrom->idPaymentFrom);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($paymentFroms->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy() {
        /* Capturamos los datos enviados por ajax */
        $PaymentFrom = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->paymentFromRepository->destroy($PaymentFrom->idPaymentFrom);
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se desactivo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    /**
     * Restore the specified typeuser from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function active() {
        /* Capturamos los datos enviados por ajax */
        $PaymentFrom = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->paymentFromRepository->onlyTrashedFind($PaymentFrom->idPaymentFrom);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }
}
