<?php

namespace AccountHon\Http\Controllers;

use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\AffiliateRepository;
use AccountHon\Repositories\RecordPercentageRepository;
use AccountHon\Repositories\DuesRepository;

class AffiliatesRecordPercentageController extends Controller
{
    
    private $affiliateRepository;
    private $recordPercentageRepository;
    private $duesRepository;

    public function __construct(
        AffiliateRepository $affiliateRepository,
        DuesRepository $duesRepository,
        RecordPercentageRepository $recordPercentageRepository
        )
    {
        $this->middleware('auth');
        $this->affiliateRepository = $affiliateRepository;
        $this->recordPercentageRepository=$recordPercentageRepository;
        $this->duesRepository=$duesRepository;
    }    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $affiliates = $this->duesRepository->all();
        return View('dues.index',compact('affiliates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $affiliates = $this->affiliateRepository->all();
        $recordPercentages = $this->recordPercentageRepository->last();
        return View('dues.create',compact('affiliates','recordPercentages'));
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
          $affiliates = $this->affiliateRepository->token($affiliate->affiliate_token);
          $recordPercentages = $this->recordPercentageRepository->token($affiliate->recordPercentage_token);

           $affiliateRecordPercentages = $this->affiliateRepository->find($affiliates->id);
          $affiliateRecordPercentages->RecordPercentages->attach($recordPercentages->id);
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

}
