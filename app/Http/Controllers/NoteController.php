<?php

namespace AccountHon\Http\Controllers;

use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\NoteRepository;
use AccountHon\Repositories\TypeFormRepository;
class NoteController extends Controller
{
        private $noteRepository;
    /**
     * @var TypeFormRepository
     */
    private $typeFormRepository;

    /**
     * Create a new controller instance.
     */
    public function __construct(NoteRepository $noteRepository, TypeFormRepository $typeFormRepository) {
        $this->noteRepository = $noteRepository;
        $this->middleware('auth');
        $this->typeFormRepository = $typeFormRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $notes = $this->noteRepository->orderBy('date', 'ASC');
        return view('notes.index', compact('notes'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $note = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($note, 'Note');
        $Validation['token']= $note->school_idNote;
        /* Declaramos las clases a utilizar */
        $notes = $this->noteRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($notes->isValid((array) $Validation)):
            $notes->fill($Validation);
            $notes->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($note->statusNote == true):
                $this->noteRepository->withTrashedFind($notes->id)->restore();
            else:
                $this->noteRepository->destroy($notes->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($notes->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $note = $this->noteRepository->withTrashedFind($id);
        $typeForms = $this->typeFormRepository->withTrashedOrderBy('name','ASC');
        return view('notes.edit', compact('note','typeForms'));
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
        $note = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($note, 'Note');
        $Validation['type_id']= $note->typeIdNote;
        /* Declaramos las clases a utilizar */
        $notes = $this->noteRepository->withTrashedFind($note->idNote);
        /* Validamos los datos para guardar tabla menu */
        if ($notes->isValid((array) $Validation)):
            $notes->fill($Validation);
            $notes->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($note->statusNote == true):
                $this->noteRepository->withTrashedFind($note->idNote)->restore();
            else:
                $this->noteRepository->destroy($note->idNote);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($notes->errors);
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
        $Note = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->noteRepository->destroy($Note->idNote);
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
        $Note = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->noteRepository->onlyTrashedFind($Note->idNote);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }
}
