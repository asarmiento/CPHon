<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 16/07/2015
 * Time: 07:35 AM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\Setting;

class SettingRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Setting();
    }

    public function whereDuoData($id){
        return $this->newQuery()->where('type_seat_id', $id)->get();
    }
}