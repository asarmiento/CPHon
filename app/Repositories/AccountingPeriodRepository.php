<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 05/07/2015
 * Time: 09:58 PM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\AccountingPeriod;

class AccountingPeriodRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new AccountingPeriod();
    }
}