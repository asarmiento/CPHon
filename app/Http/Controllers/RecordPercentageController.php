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
         $this->validate($request,['year'=>'required', 
            'month'=>'required', 'percentage_affiliates'=>'required', 
            'percentage'=>'required','token'=>'required']);
        $recordPercentage = $this->CreacionArray($request->all(),'RecordPercentage');
        $RecordPercentage = $this->recordPercentageRepository->getModel();
        $RecordPercentage->fill($recordPercentage);
        $RecordPercentage->save();
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
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
