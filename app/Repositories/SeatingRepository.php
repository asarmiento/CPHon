<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 02/07/2015
 * Time: 11:44 AM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\Seating;

class SeatingRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Seating();
    }
    public function updateWhere($token, $status,$data){
        $cambio= $this->newQuery()->where('token', $token)->update([$data=>$status]);
        return $cambio;
    }
    public function whereSelect($data,$id,$order,$dataTwo, $idTwo){
        return $this->newQuery()->where($dataTwo, $idTwo)->where($data, $id)->orderBy($order,'DESC')->get();
    }


    public function catalogPeriod($catalog,$period,$type){
        
        return $this->newQuery()->where('type_id',$type)
            ->where('accounting_period_id',$period)
            ->where('catalog_id',$catalog)->sum('amount');
    }

    public function catalogPartPeriod($catalog,$period,$type){

        return $this->newQuery()->where('type_id','<>' ,$type)
            ->where('accounting_period_id',$period)
            ->where('catalogPart_id',$catalog)->sum('amount');
    }

    public function amountSeating($code, $typeSeat){
        return $this->newQuery()->where('code',$code)->where('type_seat_id',$typeSeat)->sum('amount');

    }
}