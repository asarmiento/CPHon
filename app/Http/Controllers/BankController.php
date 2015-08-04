<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Repositories\SchoolsRepository;
use Illuminate\Http\Request;
use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\BankRepository;
class BankController extends Controller {

    private $bankRepository;
    /**
     * @var SchoolsRepository
     */
    private $schoolsRepository;

    /**
     * Create a new controller instance.
     * @param BankRepository $bankRepository
     * @param SchoolsRepository $schoolsRepository
     */
    public function __construct(BankRepository $bankRepository,SchoolsRepository $schoolsRepository) {
        $this->bankRepository = $bankRepository;
        $this->middleware('auth');
        $this->schoolsRepository = $schoolsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        if(userSchool()):
            $banks = $this->bankRepository->whereId('school_id', userSchool()->id);
            return view('banks.index', compact('banks'));
        endif;
        /* Redireccionamos a la vista de institucion con el helpers*/
        return redirect()->action(actionList());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        return view('banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $bank = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($bank, 'Bank');
        $Validation['school_id']= userSchool()->id;
        /* Declaramos las clases a utilizar */
        $banks = $this->bankRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($banks->isValid((array) $Validation)):
            $banks->fill($Validation);
            $banks->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($bank->statusBank == true):
                $this->bankRepository->withTrashedFind($banks->id)->restore();
            else:
                $this->bankRepository->destroy($banks->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($banks->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $bank = $this->bankRepository->withTrashedFind($id);

        return view('banks.edit', compact('bank'));

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
        $bank = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($bank, 'Bank');
        $Validation['school_id']= userSchool()->id;
        /* Declaramos las clases a utilizar */
        $banks = $this->bankRepository->token($bank->tokenBank);
        /* Validamos los datos para guardar tabla menu */
        if ($banks->isValid((array) $Validation)):
            $banks->fill($Validation);
            $banks->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($bank->statusBank == true):
                $this->bankRepository->withTrashedFind($bank->idBank)->restore();
            else:
                $this->bankRepository->destroy($bank->idBank);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($banks->errors);
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
        $Bank = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->bankRepository->destroy($Bank->idBank);
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
        $Bank = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->bankRepository->onlyTrashedFind($Bank->idBank);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
