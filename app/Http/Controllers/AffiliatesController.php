<?php

namespace AccountHon\Http\Controllers;

use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\AffiliateRepository;

class AffiliatesController extends Controller
{
    private $affiliateRepository;

    public function __construct(
        AffiliateRepository $affiliateRepository
        )
    {
        $this->affiliateRepository = $affiliateRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $affiliates = $this->affiliateRepository->all();
        return View('affiliates.index',compact('affiliates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View('affiliates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
            
        $affiliate = $this->CreacionArray($request->all(),'Affiliate');
        $affiliate['affiliation']= date('Y-m-d');
        $affiliate['status']= 'Activo';
        $affiliates = $this->affiliateRepository->getModel();
        if($affiliates->isValid($affiliate)):
        $affiliates->fill($affiliate);
        $affiliates->save();
        return $this->exito('Se ha Guardado con exito !!!');
        endif;

         return $this->errores($affiliates->errors);
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
        $affiliate = $this->affiliateRepository->token($token);
        return $affiliate;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $token)
    {
        $affiliate = $this->CreacionArray($request->all(),'Affiliate');
        $affiliate['affiliation']= date('Y-m-d');
        $affiliate['status']= 'Activo';
        $affiliates = $this->affiliateRepository->token($token);
        if($affiliates->isValid($affiliate)):
        $affiliates->fill($affiliate);
        $affiliates->save();
        return $this->exito('Se ha Guardado con exito !!!');
        endif;

         return $this->errores($affiliates->errors);
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
