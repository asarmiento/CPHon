<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Entities\DegreeSchool;
use AccountHon\Entities\School;
use AccountHon\Repositories\DegreeSchoolRepository;
use AccountHon\Repositories\DegreesRepository;
use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\CostRepository;
class CostController extends Controller
{
    private $costRepository;
    /**
     * @var DegreesRepository
     */
    private $degreesRepository;
    /**
     * @var DegreeSchoolRepository
     */
    private $degreeSchoolRepository;

    /**
     * @param CostRepository $costRepository
     * @param DegreesRepository $degreesRepository
     */
    public function __construct(
        CostRepository $costRepository,
        DegreesRepository $degreesRepository,
        DegreeSchoolRepository $degreeSchoolRepository
    ) {
        $this->middleware('sessionOff');
        $this->costRepository =$costRepository;
        $this->degreesRepository = $degreesRepository;
        $this->degreeSchoolRepository = $degreeSchoolRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $costs = $this->costRepository->costSchool();
         return View('costs.index', compact('costs'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $degrees = $this->degreesRepository->schoolsActive();
        return View('costs.create',compact('degrees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
         //   echo json_encode($request); die;
        $costs = $this->convertionObjeto();

        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($costs, 'Cost');
        $degrees = $this->degreesRepository->token($costs->degreeSchoolCost);
        $degreeSchool = $this->degreeSchoolRepository->whereDuoData($degrees->id, userSchool()->id);
        $Validation['degree_school_id']= $degreeSchool[0]->id;
        $Validation['monthly_payment']= $Validation['monthlyPayment'];
        /* Declaramos las clases a utilizar */
        $Cost = $this->costRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($Cost->isValid($Validation)):
            $Cost->fill($Validation);
            $Cost->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
                     /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($Cost->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($token) {
        $cost = $this->costRepository->token($token);
        $degrees = $this->degreesRepository->schoolsActive();
        return View('costs.edit', compact('cost','degrees'));
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
        $costs = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($costs, 'Cost');
        /** @var TYPE_NAME $Validation */
        $degrees = $this->degreesRepository->token($costs->degreeSchoolCost);
        $degreeSchool = $this->degreeSchoolRepository->whereDuoData($degrees->id, userSchool()->id);
        $Validation['degree_school_id']= $degreeSchool[0]->id;
        $Validation['monthly_payment']= $Validation['monthlyPayment'];
      //  echo json_encode($Validation); die;
        /* Declaramos las clases a utilizar */
        $Cost = $this->costRepository->token($costs->token);
        /* Validamos los datos para guardar tabla menu */
        if ($Cost->isValid($Validation)):
            $Cost->fill($Validation);
            $Cost->save();
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($Cost->errors);
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
        $costs = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->costRepository->find($id);
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
        $costs = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->costRepository->withTrashedFind($id)->restore();

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
