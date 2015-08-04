<?php

namespace AccountHon\Http\Controllers;

use Illuminate\Http\Request;
use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\TypeFormRepository;
class TypeFormController extends Controller {

    private $typeFormRepository;

    /**
     * Create a new controller instance.
     * @param TypeFormRepository $typeFormRepository
     */
    public function __construct(TypeFormRepository $typeFormRepository) {
        $this->typeFormRepository = $typeFormRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $typeForms = $this->typeFormRepository->withTrashedOrderBy('name','ASC');
        return view('typeForms.index', compact('typeForms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('typeForms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $typeForm = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($typeForm, 'TypeForm');
        /* Declaramos las clases a utilizar */
        $typeForms = $this->typeFormRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($typeForms->isValid((array) $Validation)):
            $typeForms->fill($Validation);
            $typeForms->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($typeForms->statusTypeForm == true):
                $this->typeFormRepository->withTrashedFind($typeForms->id)->restore();
            else:
                $this->typeFormRepository->destroy($typeForms->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($typeForms->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $typeForm = $this->typeFormRepository->withTrashedFind($id);

        return view('typeForms.edit', compact('typeForm'));
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
        $typeForm = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($typeForm, 'TypeForm');
        /* Declaramos las clases a utilizar */
        $typeForms = $this->typeFormRepository->withTrashedFind($typeForm->idTypeForm);
        /* Validamos los datos para guardar tabla menu */
        if ($typeForms->isValid((array) $Validation)):
            $typeForms->fill($Validation);
            $typeForms->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($typeForms->statusTypeForm == true):
                $this->typeFormRepository->withTrashedFind($typeForm->idTypeForm)->restore();
            else:
                $this->typeFormRepository->destroy($typeForm->idTypeForm);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($typeForms->errors);
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
        $typeForm = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->typeFormRepository->destroy($typeForm->idTypeForm);
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
        $typeForm = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->typeFormRepository->onlyTrashedFind($typeForm->idTypeForm);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
