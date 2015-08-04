<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Repositories\SettingRepository;
use Illuminate\Http\Request;
use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\CatalogRepository;
use AccountHon\Repositories\TypeSeatRepository;
use Illuminate\Support\Facades\Crypt;

class SettingsController extends Controller {

    /**
     * @var CatalogRepository
     */
    private $catalogRepository;

    /**
     * @var TypeSeatRepository
     */
    private $typeSeatRepository;

    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @param CatalogRepository $catalogRepository
     * @param TypeSeatRepository $typeSeatRepository
     * @param SettingRepository $settingRepository
     */
    public function __construct(
    CatalogRepository $catalogRepository, TypeSeatRepository $typeSeatRepository, SettingRepository $settingRepository
    ) {

        $this->catalogRepository = $catalogRepository;
        $this->typeSeatRepository = $typeSeatRepository;
        $this->settingRepository = $settingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $settings = $this->settingRepository->getModel()->all();
        return View('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $catalogs = $this->catalogRepository->getModel()->where('style', 'Detalle')->where('school_id', userSchool()->id)->orderBy('code', 'ASC')->get();
        $typeSeat = $this->typeSeatRepository->whereDuoData('CorCa');
        $setting = $this->settingRepository->getModel()->where('type_seat_id', $typeSeat[0]->id)->get();
        return View('settings.create', compact('catalogs', 'typeSeat', 'setting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $settings = $this->convertionObjeto();
        $typeSeat = $this->typeSeatRepository->token($settings->typeSeatSetting);
        $catalog = $this->catalogRepository->token($settings->catalogSetting);
        $Validation['type_seat_id'] = $typeSeat->id;
        $Validation['catalog_id'] = $catalog->id;
        $Validation['token'] = Crypt::encrypt($catalog->id);
        $settingVerif = $this->settingRepository->getModel()->where('type_seat_id', $typeSeat->id)->get();
        
        if (!$settingVerif->isEmpty()):
            return $this->errores(['setting save' => 'Ya existe la configuracion para ' . $typeSeat->name]);
        endif;
        /* Validamos los datos para guardar tabla menu */
        $setting = $this->settingRepository->getModel();
        if ($setting->isValid($Validation)):
            $setting->fill($Validation);
            $setting->save();

            return $this->exito('Se Guardo con exito la cuenta');
        endif;

        return $this->errores($setting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $token
     * @return Response
     */
    public function edit($token) {

        $setting = $this->settingRepository->token($token);
        $catalogs = $this->catalogRepository->getModel()->where('style', 'Detalle')->where('school_id', userSchool()->id)->orderBy('code', 'ASC')->get();

        return View('settings.edit', compact('setting', 'catalogs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update() {
        $settings = $this->convertionObjeto();

        $setting = $this->settingRepository->token($settings->token);
        $typeSeat = $this->typeSeatRepository->token($settings->typeSeatSetting);
        $catalog = $this->catalogRepository->token($settings->catalogSetting);
        $Validation['type_seat_id'] = $typeSeat->id;
        $Validation['catalog_id'] = $catalog->id;
        /* Validamos los datos para guardar tabla menu */
        if ($setting->isValid($Validation)):
            $setting->fill($Validation);
            $setting->save();

            return $this->exito('Se Actualizo con exito la cuenta');
        endif;

        return $this->errores($setting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
