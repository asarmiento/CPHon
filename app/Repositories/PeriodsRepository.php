<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 21/06/2015
 * Time: 08:30 PM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\AccountingPeriod;

class PeriodsRepository extends baseRepository{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new AccountingPeriod();
    }
}