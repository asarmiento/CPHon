<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 10/07/2015
 * Time: 01:34 AM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\TempAuxiliarySeat;

class TempAuxiliarySeatRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new TempAuxiliarySeat();
    }
}