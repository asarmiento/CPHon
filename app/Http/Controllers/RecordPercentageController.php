<?php

namespace AccountHon\Http\Controllers;

use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\AffiliateRepository;
use AccountHon\Repositories\RecordPercentageRepository;

class RecordPercentageController extends Controller
{
    private $recordPercentageRepository;
    /**
     * [__construct middleware for authentication]
     */
    public function __construct(
        RecordPercentageRepository $recordPercentageRepository
        ){
        $this->middleware('auth');

        $this->recordPercentageRepository=$recordPercentageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $recordPercentages = $this->recordPercentageRepository->all();
        return View('recordPercentages.index', compact('recordPercentages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View('recordPercentages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
      
        $recordPercentage = $this->CreacionArray($request->all(),'RecordPercentage');
       $RecordPercentage = $this->recordPercentageRepository->getModel();
        if($RecordPercentage->isValid($recordPercentage)):
        $RecordPercentage->fill($recordPercentage);
        $RecordPercentage->save();

        return $this->exito('Se ha Guardado con exito !!!');

        endif;

         return $this->errores($RecordPercentage->errors);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $token
     * @return Response
     */
    public function edit($token)
    {
        $recordPercentage = $this->recordPercentageRepository->token($token);
        return $recordPercentage;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $token
     * @return Response
     */
    public function update(Request $request, $token)
    {
         $recordPercentage = $this->CreacionArray($request->all(),'RecordPercentage');
       $RecordPercentage = $this->recordPercentageRepository->token($token);
        if($RecordPercentage->isValid($recordPercentage)):
        $RecordPercentage->fill($recordPercentage);
        $RecordPercentage->save();

        return $this->exito('Se ha Guardado con exito !!!');

        endif;

         return $this->errores($RecordPercentage->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function modal(){
        return view('recordPercentages.create');
    }
}
