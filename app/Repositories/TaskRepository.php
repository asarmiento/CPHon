<?php

namespace AccountHon\Repositories;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use AccountHon\Entities\Task;

/**
 * Description of TaskRepository
 *
 * @author Anwar Sarmiento
 */
class TaskRepository extends BaseRepository {

    public function getModel() {
        return new Task();
    }

    public static function urlMenu($id) {
        return $this->find($id)->menus->url;
    }

    

}
