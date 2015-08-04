<?php

namespace AccountHon\Repositories;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use AccountHon\Entities\Degree;
use AccountHon\Entities\School;
/**
 * Description of DegreesRepository
 *
 * @author Anwar Sarmiento
 */
class DegreesRepository extends BaseRepository {

    /**
     * @var SchoolsRepository
     */
    private $schoolsRepository;

    public function __construct(SchoolsRepository $schoolsRepository){

        $this->schoolsRepository = $schoolsRepository;
    }

    public function getModel() {
        return new Degree();
    }

    public function schoolsActive(){
        return $this->schoolsRepository->find(userSchool()->id)->degrees;
    }
}
