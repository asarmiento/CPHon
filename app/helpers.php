<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 12:18 PM
 */

function currentUser()
{
    return auth()->user();
}
function recordPercentage(){
  return  \AccountHon\Entities\RecordPercentage::orderBy('id','DESC')->get()->last();
}
function convertTitle($string){

    $string = strtolower($string);

    return ucwords($string);
}

function months(){
    return array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SETIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
}

function dateVoluntary(){
    return '60';
}
function dateMandatory(){
    return '65';
}
function schoolSession($school){
    \Session::put('school', $school);
}

function userSchool(){

    return \Session::get('school');
}

function actionList(){
    return 'SchoolsController@listSchools';
}

function changeLetterMonth($month){
 $months=   ['01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre'];
return $months[$month];
}

/**
 * @return mixed
 */
function periodSchool()
{
    if(userSchool()):
    return \AccountHon\Entities\AccountingPeriod::where('school_id',userSchool()->id)->get()->last();
    endif;

    return false;

}
function period(){
    if(periodSchool()){
        return periodSchool()->month.'-'.periodSchool()->year;
    }else{
        return "No existe periodo contable.";
    }
}
function dateShort()
{
    $mes_actual = date("n");
    $mes=periodSchool()->month;
    if($mes != $mes_actual):

        $year = periodSchool()->year;
        $dia = date("d",(mktime(0,0,0,$mes+1,1,$year)-1));

        return $salida ="$year/$mes/$dia";

    endif;
    return date("Y/m/d");
}
function addPage($add = null)
{
    if($add)
    {
        $pageCurrent = Session::get('page');
        Session::put('page', $pageCurrent +1);
    }else{
        Session::put('page', 1);
    }
}
function destroyPage()
{
    Session::forget('page');
}