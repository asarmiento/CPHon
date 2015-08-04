<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 24/06/2015
 * Time: 10:32 AM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\DegreeSchool;

class DegreeSchoolRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new DegreeSchool();
    }

    public function whereDuoData($id, $idTwo){
        return $this->newQuery()->where('degree_id', $id)->where('school_id', $idTwo)->get();
    }


}