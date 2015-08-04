<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 29/06/2015
 * Time: 08:56 PM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\Deposit;

class DepositRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Deposit();
    }
}