<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 30/06/2015
 * Time: 11:18 PM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\Catalog;

class CatalogRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel()
    {
       return new Catalog();
    }

    public function accountSchool(){
        return $this->whereDuo('school_id',userSchool()->id,'style','Detalle','id','ASC');

    }
}