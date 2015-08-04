<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 19/07/2015
 * Time: 08:58 AM
 */

namespace AccountHon\Http\Controllers\ReportExcel;

use AccountHon\Http\Controllers\ReportExcelController;

class estadoResultado extends ReportExcelController {

    public function index(){

    }

    public function report(){

        $school = $this->schoolsRepository->whereId('id',userSchool()->id,'id');
        $headers = array(
            array($school[0]->name),
            array($school[0]->charter),
            array('Tel.: '.$school[0]->phoneOne.' Fax: '.$school[0]->fax),
            array('ESTADO DE RESULTADO'),
            array('MES DE '),
            array(''),
            array('INGRESOS: ')
        );
        $catalogs = $this->catalogRepository->getModel()->where('id',userSchool()->id)->get();

        $content =$headers;

        foreach($catalogs AS $catalog):
            echo json_encode($catalog);
            if($catalog->type=='4'):
                $content[]=array($catalog->code,$catalog->name);
                endif;
            endforeach;
        echo json_encode($content); die;
    }

}