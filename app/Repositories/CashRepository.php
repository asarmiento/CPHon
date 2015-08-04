<?php

/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 30/06/2015
 * Time: 12:54 AM
 */

namespace AccountHon\Repositories;

use AccountHon\Entities\Cash;

class CashRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel() {
        return new Cash();
    }

    public function sumTypeSchool($column1, $filter1) {
        return $this->newQuery()->where('school_id', userSchool()->id)->whereIn($column1, $filter1)->sum('amount');
    }

}
