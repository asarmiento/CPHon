<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Repositories\TypeSeatRepository;
use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;

class TypeSeatController extends Controller
{

    /**
     * @var TypeSeatRepository
     */
    private $typeSeatRepository;

    public function __construct(TypeSeatRepository $typeSeatRepository){

        $this->typeSeatRepository = $typeSeatRepository;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $typeSeats = $this->typeSeatRepository->whereId('school_id', userSchool()->id, 'id');
        return View('typeSeats.index', compact('typeSeats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View('typeSeats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */

        //   echo json_encode($request); die;
        $typeSeats = $this->convertionObjeto();

        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($typeSeats, 'TypeSeat');
        $Validation['school_id']= userSchool()->id;
        /* Declaramos las clases a utilizar */
        $TypeSeat = $this->typeSeatRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($TypeSeat->isValid($Validation)):
            $TypeSeat->fill($Validation);
            $TypeSeat->save();
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($TypeSeat->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($token) {
        $typeSeat = $this->typeSeatRepository->withTrashedFind($token);

        return View('typeSeats.edit', compact('typeSeat'));
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
        $typeSeats = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($typeSeats, 'TypeSeat');
        /** @var TYPE_NAME $Validation */
        $Validation['school_id']= userSchool()->id;
        /* Declaramos las clases a utilizar */
        $TypeSeat = $this->typeSeatRepository->withTrashedFind($typeSeats->idTypeSeat);
        /* Validamos los datos para guardar tabla menu */
        if ($TypeSeat->isValid($Validation)):
            $TypeSeat->fill($Validation);
            $TypeSeat->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($typeSeats->statusTypeSeat == true):
                /** @var TYPE_NAME $this */
                $this->typeSeatRepository->withTrashedFind($typeSeats->idTypeSeat)->restore();
            else:
                /** @var TYPE_NAME $this */
                $this->typeSeatRepository->destroy($typeSeats->idTypeSeat);
            endif;
            /* Con este methodo creamos el archivo Json */
            $this->fileJsonUpdate();
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($TypeSeat->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id) {
        /* Capturamos los datos enviados por ajax */
        $typeSeats = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->typeSeatRepository->find($id);
        if ($data):
            $data->delete();
            /* Con este methodo creamos el archivo Json */
            $this->fileJsonUpdate();
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
    public function active($id) {
        /* Capturamos los datos enviados por ajax */
        $typeSeats = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->typeSeatRepository->withTrashedFind($id)->restore();

        if ($data):
            /* Con este methodo creamos el archivo Json */
            $this->fileJsonUpdate();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
