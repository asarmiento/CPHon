<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 24/06/2015
 * Time: 09:20 PM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\FinancialRecords;

class FinancialRecordsRepository extends BaseRepository{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new FinancialRecords();
    }

    public function saldoStudent($id){
        return $this->newQuery()->where('id',$id)->sum('balance');
    }

    public function updateData($id,$data,$balance){
        return $this->newQuery()->where('id',$id)->update([$data=>$balance]);
    }
}