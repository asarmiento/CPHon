<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 24/06/2015
 * Time: 09:14 PM
 */
namespace AccountHon\Repositories;
use AccountHon\Entities\AuxiliarySeat;
class AuxiliarySeatRepository extends BaseRepository {
    /**
     * @return mixed
     */
    public function getModel()
    {
        return new AuxiliarySeat();
    }
    public function updateWhere($token, $status,$data){
        $cambio= $this->newQuery()->where('token', $token)->update([$data=>$status]);
        return $cambio;
    }
    public function updateDataWhere($upData, $token,$data, $status){
        return $this->newQuery()->where($upData, $token)->update([$data=>$status]);

    }
    public function whereSelect($data,$id,$order,$dataTwo, $idTwo){
        return $this->newQuery()->where($dataTwo, $idTwo)->where($data, $id)->orderBy($order,'DESC')->get();
    }
    
    public function saldoStudentPeriod($idFinantial,$period,$type){
        return $this->newQuery()->where('type_id',$type)
            ->where('accounting_period_id',$period)
            ->where('financial_records_id',$idFinantial)->sum('amount');
    }
    
        public function amountSeating($code, $typeSeat){
        return $this->newQuery()->where('code',$code)->where('type_seat_id',$typeSeat)->sum('amount');

    }
}