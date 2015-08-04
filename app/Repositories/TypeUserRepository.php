<?php

namespace AccountHon\Repositories;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use AccountHon\Entities\TypeUser;

/**
 * Description of TypeUserRepository
 *
 * @author Anwar Sarmiento
 */
class TypeUserRepository extends BaseRepository {

    public function getModel() {
        return new TypeUser();
    }

}
