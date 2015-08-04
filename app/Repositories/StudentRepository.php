<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 24/06/2015
 * Time: 05:32 PM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\Student;

class StudentRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Student();
    }
}