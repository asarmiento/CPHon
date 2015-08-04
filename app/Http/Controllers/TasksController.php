<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Repositories\TaskRepository;
use AccountHon\Repositories\MenuRepository;

class TasksController extends Controller {

    private $taskRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(TaskRepository $taskRepository, MenuRepository $menuRepository) {
        $this->taskRepository = $taskRepository;
        $this->menuRepository = $menuRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $tasks = $this->taskRepository->withTrashedOrderBy('name', 'ASC');

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $task = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $task->nameTask);
        /* Declaramos las clases a utilizar */
        $tasks = $this->taskRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($tasks->isValid((array) $ValidationData)):
            $tasks->fill($ValidationData);
            $tasks->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($task->statusTask == true):
                $this->taskRepository->withTrashedFind($tasks->id)->restore();
            else:
                $this->taskRepository->destroy($tasks->id);
            endif;
            
            $menus = $this->menuRepository->all();
            foreach ($menus as $menu) {
                $menu->Tasks()->attach($tasks->id, array('status' => 0));
            }
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($tasks->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $task = $this->taskRepository->findOrFail($id);

        return view('tasks.edit', compact('task'));
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
        $task = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $task->nameTask);
        /* Declaramos las clases a utilizar */
        $tasks = $this->taskRepository->withTrashedFind($task->idTask);
        /* Validamos los datos para guardar tabla menu */
        if ($tasks->isValid((array) $ValidationData)):
            $tasks->fill($ValidationData);
            $tasks->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($task->statusTask == true):
                $this->taskRepository->withTrashedFind($task->idTask)->restore();
            else:
                $this->taskRepository->destroy($task->idTask);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($tasks->errors);
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
        $Task = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->taskRepository->destroy($Task->idTask);
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
        $Task = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->taskRepository->onlyTrashedFind($Task->idTask);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
