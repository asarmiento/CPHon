<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Entities\Menu;
use AccountHon\Entities\Task;
use Illuminate\Support\Facades\Response;
use AccountHon\Repositories\MenuRepository;
use AccountHon\Repositories\TaskRepository;

class MenuController extends Controller {

    private $menuRepository;
    private $taskRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(MenuRepository $menuRepository, TaskRepository $taskRepository) {
        $this->menuRepository = $menuRepository;
        $this->taskRepository = $taskRepository;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $menus = $this->menuRepository->withTrashedOrderBy('name', 'ASC');
        $tasks = $this->taskRepository->getModel()->all();

        return view('menus.index', compact('menus', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $tasks = $this->taskRepository->getModel()->all();

        return view('menus.create')->with('tasks', $tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $menus = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $menus->nameMenu, 'url' => $menus->urlMenu, 'icon_font' => $menus->iconMenu);
        /* Declaramos las clases a utilizar */
        $menu = $this->menuRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($menu->isValid((array) $ValidationData)):
            $menu->fill($ValidationData);
            $menu->save();
            /* Traemos el id del ultimo registro guardado */
            $stateTasks = $menus->stateTasks;
            /* corremos las variables boleanas para Insertar a la tabla de relación */
            for ($i = 0; $i < count($stateTasks); $i++):
                /* Comprobamos cuales estan habialitadas y esas las guardamos */
                $Relacion = $this->menuRepository->find($menu->id);
                $Relacion->Tasks()->attach($menus->idTasks[$i], array('status' => $stateTasks[$i]));
            endfor;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($menu->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $menu = $this->menuRepository->withTrashedFind($id);
        $tasks = $this->taskRepository->getModel()->all();
        return view('menus.edit', compact('menu','tasks'));
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
        $menus = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $menus->nameMenu, 'url' => $menus->urlMenu, 'icon_font' => $menus->iconMenu);
        /* Declaramos las clases a utilizar */
        $menu = $this->menuRepository->withTrashedFind($menus->idMenu);
        $menu->Tasks()->detach();
        /* Validamos los datos para guardar tabla menu */
        if ($menu->isValid((array) $ValidationData)):
            $menu->fill($ValidationData);
            $menu->save();
            /* Traemos el id del ultimo registro guardado */
            $stateTasks = $menus->stateTasks;
            /* corremos las variables boleanas para Insertar a la tabla de relación */
            for ($i = 0; $i < count($stateTasks); $i++):
                /* Comprobamos cuales estan habialitadas y esas las guardamos */
                $Relacion = $this->menuRepository->withTrashedFind($menus->idMenu);
                $Relacion->Tasks()->attach($menus->idTasks[$i], array('status' => $stateTasks[$i]));
            endfor;
            /* Comprobamos si el usuario esta cambiando el estado del menu en editar */
            if (($menus->statusMenu) == false):
                $this->menuRepository->destroy($menus->idMenu);
                /* Enviamos el mensaje de guardado correctamente */
                return $this->exito('Los datos se Actualizaron con exito!!!');
            endif;
            /* Activamos el menu segun la peticion del usuario */
            $menu->restore();
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se Actualizaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($menu->errors);
    }

    /**
     * Remove the specified typeuser from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy() {
        /* Capturamos los datos enviados por ajax */
        $menus = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->menuRepository->destroy($menus->idMenu);
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
        $menus = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->menuRepository->onlyTrashedFind($menus->idMenu);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
