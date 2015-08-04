<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Entities\School;
use Illuminate\Support\Facades\Response;
use AccountHon\Repositories\SchoolsRepository;
use AccountHon\Repositories\TypeSeatRepository;
use AccountHon\Repositories\AccountingPeriodRepository;
use AccountHon\Repositories\CatalogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class SchoolsController extends Controller {

    private $schoolsRepository;
    /**
     * @var CatalogRepository
     */
    private $catalogRepository;

    /**
     * Create a new controller instance.
     * @param SchoolsRepository $schoolsRepository
     * @param TypeSeatRepository $typeSeatRepository
     * @param AccountingPeriodRepository $accountingPeriodRepository
     */
    public function __construct(
            SchoolsRepository $schoolsRepository,
            TypeSeatRepository $typeSeatRepository,
            AccountingPeriodRepository $accountingPeriodRepository,
            CatalogRepository $catalogRepository
        ) {
            $this->schoolsRepository          = $schoolsRepository;
            $this->typeSeatRepository         = $typeSeatRepository;
            $this->accountingPeriodRepository = $accountingPeriodRepository;
            $this->middleware('auth');
        $this->catalogRepository = $catalogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $schools = $this->schoolsRepository->withTrashedOrderBy('name', 'ASC');

        return View('schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View('schools.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $schools = $this->convertionObjeto();

        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($schools, 'School');

        /* Declaramos las clases a utilizar */
        $saveSchools = $this->schoolsRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($saveSchools->isValid($Validation)):
            $saveSchools->fill($Validation);
            DB::beginTransaction();
            if($saveSchools->save()){
                /* Comprobamos si viene activado o no para guardarlo de esa manera */
                if ($schools->statusSchool == true):
                    $this->schoolsRepository->withTrashedFind($saveSchools->id)->restore();
                else:
                    $this->schoolsRepository->destroy($saveSchools->id);
                endif;
                /* Con este methodo creamos el archivo Json */
                $this->fileJsonUpdate();
                /* Enviamos el mensaje de guardado correctamente */


                if($this->createAccountingPeriod($saveSchools->id)){
                    if($this->createTypeSeats($saveSchools->id)){
                        if($this->createCatalog($saveSchools->id)){
                            DB::commit();
                            return $this->exito('Los datos se guardaron con exito!!!');
                        }else{
                            DB::rollback();
                            return $this->errores('No se ha podido crear la Institución (Catalogo de Cuentas).');
                        }
                    }else{
                        DB::rollback();
                        return $this->errores('No se ha podido crear la Institución (Tipos de Asientos).');    
                    }
                }else{
                    DB::rollback();
                    return $this->errores('No se ha podido crear la Institución (Periodo Contable).');
                }
            }
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($saveSchools->errors);
    }
    private function createCatalog($school_id){
        /* Creamos un array para los parametros */
        $Validations = array(
            array('code' => '01-00-00-00-000', 'name' => 'ACTIVOS', 'school_id' => $school_id, 'token' => bcrypt('ACTIVOS'),  'catalog_id' => NULL,'style' => 'Grupo', 'note' => 'false',  'type' => '1', 'level' => '1', 'user_created' => currentUser()->id),
            array('code' => '02-00-00-00-000', 'name' => 'PASIVOS', 'school_id' => $school_id, 'token' => bcrypt('PASIVOS'),  'catalog_id' => NULL,'style' => 'Grupo', 'note' => 'false',  'type' => '2', 'level' => '1', 'user_created' => currentUser()->id),
            array('code' => '03-00-00-00-000', 'name' => 'CAPITAL', 'school_id' => $school_id, 'token' => bcrypt('CAPITAL'),  'catalog_id' => NULL,'style' => 'Grupo', 'note' => 'false',  'type' => '3', 'level' => '1', 'user_created' => currentUser()->id),
            array('code' => '04-00-00-00-000', 'name' => 'INGRESOS', 'school_id' => $school_id, 'token' => bcrypt('INGRESOS'),  'catalog_id' => NULL,'style' => 'Grupo', 'note' => 'false',  'type' => '4', 'level' => '1', 'user_created' => currentUser()->id),
            array('code' => '05-00-00-00-000', 'name' => 'COMPRAS', 'school_id' => $school_id, 'token' => bcrypt('COMPRAS'),  'catalog_id' => NULL,'style' => 'Grupo', 'note' => 'false',  'type' => '5', 'level' => '1', 'user_created' => currentUser()->id),
            array('code' => '06-00-00-00-000', 'name' => 'GASTOS', 'school_id' => $school_id, 'token' => bcrypt('GASTOS'),  'catalog_id' => NULL,'style' => 'Grupo', 'note' => 'false',  'type' => '6', 'level' => '1', 'user_created' => currentUser()->id)
        );

        $catalogs = $this->catalogRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        foreach($Validations AS $Validation):
        if ($catalogs->isValid($Validation)):
            $catalogs->fill($Validation);
            if($catalogs->save()){
                return true;
            }
            Log::error('No se ha podido crear el catalogo en el ID de School: '.$school_id.'.');
            return false;
        endif;
        Log::error('No es válido el Catalogo: '.$school_id.'.');
        return false;
            endforeach;
    }

    /**
     * [createAccountingPeriod description]
     * @param  [type] $school_id [description]
     * @return [type]            [description]
     */
    private function createAccountingPeriod($school_id){
        /* Creamos un array para los parametros */
        $Validation = array('month' => '01', 'year' => '2015', 'school_id' => $school_id, 'token' => bcrypt($school_id), 'period' => '201501', 'user_created' => currentUser()->id);

        $periods = $this->accountingPeriodRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($periods->isValid($Validation)):
            $periods->fill($Validation);
            if($periods->save()){
                return true;
            }
            Log::error('No se ha podido crear el Periodo Contable en el ID de School: '.$school_id.'.');
            return false;
        endif;
        Log::error('No es válido el Periodo Contable: '.$school_id.'.');
        return false;
    }

    /**
     * [createTypeSeats description]
     * @param  [type] $school_id [description]
     * @return [type]            [description]
     */
    private function createTypeSeats($school_id){
        $myArray = array('alumn' => 'Carnet Alumnos', 'DGA' => 'DIARIO GENERAL AUXILIAR', 'RCA' => 'RECIBOS DE AUXIlIAR', 'DG' => 'DIARIO GENERAL', 'RC' => 'RECIBOS DE CONTABILIDAD');
        $validate = true;
        try {
            DB::beginTransaction();
            foreach ($myArray as $abbreviation => $name) {
                $Validation = array(
                                'abbreviation' => $abbreviation, 
                                'name'         => $name, 
                                'quatity'      => 1, 
                                'year'         => '2015', 
                                'school_id'    => $school_id,
                                'token'        => bcrypt($school_id)
                              );
                $TypeSeat = $this->typeSeatRepository->getModel();
                /* Validamos los datos para guardar tabla menu */
                if ($TypeSeat->isValid($Validation)):
                    $TypeSeat->fill($Validation);
                    if($TypeSeat->save()){
                        $validate = true;
                    }else{
                        $validate = false;
                    }
                endif;
            }
            if($validate){
                DB::commit();
            }else{
                Log::error('No se han grabado algunos asientos');
                DB::rollback();
            }
        } catch (Exception $e) {
            Log::error($e);
            DB::rollback();
            return false;
        }
        if(!$validate){
            Log::error('No se han grabado algunos asientos');
            DB::rollback();
        }
        return $validate;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $school = $this->schoolsRepository->withTrashedFind($id);

        return View('schools.edit', compact('school'));
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
        $schools = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($schools, 'School');
        /* Declaramos las clases a utilizar */
        $saveSchools = $this->schoolsRepository->withTrashedFind($schools->idSchool);
        /* Validamos los datos para guardar tabla menu */
        if ($saveSchools->isValid($Validation)):
            $saveSchools->fill($Validation);
            $saveSchools->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($schools->statusSchool == true):
                $this->schoolsRepository->withTrashedFind($schools->idSchool)->restore();
            else:
                $this->schoolsRepository->destroy($schools->idSchool);
            endif;
            /* Con este methodo creamos el archivo Json */
            $this->fileJsonUpdate();
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($saveSchools->errors);
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
        $schools = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->schoolsRepository->find($id);
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
        $schools = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->schoolsRepository->withTrashedFind($id)->restore();

        if ($data):
            /* Con este methodo creamos el archivo Json */
            $this->fileJsonUpdate();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    public function fileJsonUpdate() {
        /* Buscamos todos los datos de school y traemos solo el id y el name */
        $school = School::select('id', 'name')->get();
        $dataJson = '';
        foreach ($school as $schools):
            $dataJson[] = array('value' => $schools->id, 'text' => $schools->name);
        endforeach;

        $fh = fopen('json/schools.json', 'w')
                or die('Error al abrir fichero de salida');
        fwrite($fh, json_encode($dataJson, JSON_UNESCAPED_UNICODE));
        fclose($fh);
    }

    public function listSchools(){
        $schools = currentUser()->schools;

        return view('schools/list',compact('schools'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function routeUser(){
        $schools = $this->convertionObjeto();
        $school = $this->schoolsRepository->token($schools->token);
        if($school):
            schoolSession($school);
            return $this->exito('');
            endif;
        return $this->errores('No tiene permisos para ingresar a esta institución');
    }
}
