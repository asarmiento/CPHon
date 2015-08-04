<?php

namespace AccountHon\Repositories;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use AccountHon\Entities\School;
/**
 * Description of SchoolsRepository
 *
 * @author Anwar Sarmiento
 */
class SchoolsRepository extends BaseRepository {

    public function getModel() {
        return new School();
    }

    public function newSchool(){
        
    }
    
  
}
