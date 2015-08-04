<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Repositories\TypeUserRepository;
use Illuminate\Support\Facades\Response;

class TypeUsersController extends Controller {

    private $typeUserRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(TypeUserRepository $typeUserRepository) {
        $this->typeUserRepository = $typeUserRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $typeUsers = $this->typeUserRepository->withTrashedOrderBy('name', 'ASC');
        return view('typeUsers.index', compact('typeUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('typeUsers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $typeUser = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($typeUser, 'TypeUser');
        /* Declaramos las clases a utilizar */
        $typeUsers = $this->typeUserRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($typeUsers->isValid((array) $Validation)):
            $typeUsers->fill($Validation);
            $typeUsers->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($typeUser->statusTypeUser == true):
                $this->typeUserRepository->withTrashedFind($typeUsers->id)->restore();
            else:
                $this->typeUserRepository->destroy($typeUsers->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($typeUsers->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $typeUser = $this->typeUserRepository->withTrashedFind($id);

        return view('typeUsers.edit', compact('typeUser'));
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
        $typeUser = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($typeUser, 'TypeUser');
        /* Declaramos las clases a utilizar */
        $typeUsers = $this->typeUserRepository->withTrashedFind($typeUser->idTypeUser);
        /* Validamos los datos para guardar tabla menu */
        if ($typeUsers->isValid((array) $Validation)):
            $typeUsers->fill($Validation);
            $typeUsers->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($typeUser->statusTypeUser == true):
                $this->typeUserRepository->withTrashedFind($typeUser->idTypeUser)->restore();
            else:
                $this->typeUserRepository->destroy($typeUser->idTypeUser);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($typeUsers->errors);
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
        $TypeUser = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->typeUserRepository->destroy($TypeUser->idTypeUser);
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
        $TypeUser = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->typeUserRepository->onlyTrashedFind($TypeUser->idTypeUser);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
