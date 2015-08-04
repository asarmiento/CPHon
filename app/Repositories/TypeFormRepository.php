<?php

namespace AccountHon\Repositories;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use AccountHon\Entities\TypeForm;

/**
 * Description of TypeFormRepository
 *
 * @author Anwar Sarmiento
 */
class TypeFormRepository extends BaseRepository {

    public function getModel() {
        return new TypeForm();
    }

    public function nameType($name)
    {
        $type= $this->newQuery()->where('name',$name)->get();

        return $type[0]->id;
    }
}
