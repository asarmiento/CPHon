<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 16/07/2015
 * Time: 11:46 PM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\SeatingPart;

class SeatingPartRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new SeatingPart();
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
}