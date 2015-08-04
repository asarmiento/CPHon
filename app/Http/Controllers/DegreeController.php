<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Repositories\DegreeSchoolRepository;
use AccountHon\Repositories\SchoolsRepository;
use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\DegreesRepository;
class DegreeController extends Controller
{
    private $degreesRepository;
    /**
     * @var SchoolsRepository
     */
    private $schoolsRepository;
    /**
     * @var DegreeSchoolRepository
     */
    private $degreeSchoolRepository;

    /**
     * Create a new controller instance.
     * @param DegreesRepository $degreesRepository
     * @param SchoolsRepository $schoolsRepository
     * @param DegreeSchoolRepository $degreeSchoolRepository
     */
    public function __construct(
        DegreesRepository $degreesRepository,
        SchoolsRepository $schoolsRepository,
        DegreeSchoolRepository $degreeSchoolRepository
    ) {
        $this->middleware('auth');
        $this->degreesRepository = $degreesRepository;
        $this->schoolsRepository = $schoolsRepository;
        $this->degreeSchoolRepository = $degreeSchoolRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        if(userSchool()):
            $degrees = $this->degreesRepository->schoolsActive();
            return view('degrees.index', compact('degrees'));
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
        return view('degrees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $degree = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($degree, 'Degree');
        /* Declaramos las clases a utilizar */
        $degrees = $this->degreesRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($degrees->isValid((array) $Validation)):
            $degrees->fill($Validation);
            $degrees->save();

            $relation = $this->degreesRepository->find($degrees->id);
            $relation->schools()->attach(userSchool()->id);
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($degree->statusDegree == true):
                $this->degreesRepository->withTrashedFind($degrees->id)->restore();
            else:
                $this->degreesRepository->destroy($degrees->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($degrees->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($token) {
        $degree = $this->degreesRepository->token($token);

        return view('degrees.edit', compact('degree'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update() {
        /* Capturamos los datos enviados por ajax */
        $degree = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($degree, 'Degree');
        /* Declaramos las clases a utilizar */
        $degrees = $this->degreesRepository->token($degree->token);
     //   $relation = $this->degreesRepository->find($degrees->id);
     //   $relation->schools()->detach(userSchool()->id);

        /* Validamos los datos para guardar tabla menu */
        if ($degrees->isValid((array) $Validation)):
            $degrees->fill($Validation);
            $degrees->save();
          //  $relation = $this->degreesRepository->find($degrees->id);
         //   $relation->schools()->attach(userSchool()->id);
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($degree->statusDegree == true):
                $this->degreesRepository->withTrashedFind($degrees->id)->restore();
            else:
                $this->degreesRepository->destroy($degrees->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($degrees->errors);
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
        $Degree = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->degreesRepository->token($Degree->token);
        if ($data):
            $relation = $this->degreesRepository->find($data->id);
            $relation->schools()->detach(userSchool()->id);
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
        $Degree = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->degreesRepository->token($Degree->token);

        if ($data):
            $this->degreesRepository->onlyTrashedFind($data->id)->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }
}
