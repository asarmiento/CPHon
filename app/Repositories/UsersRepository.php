<?php
namespace AccountHon\Repositories;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use AccountHon\Entities\User;
/**
 * Description of UsersRepository
 *
 * @author Anwar Sarmiento
 */
class UsersRepository extends BaseRepository {
    public function getModel() {
        return new User();
    }
   /* Generar el nombre completo del usuario */

    public function nameComplete() {
        return $this->name . ' ' . $this->last;
    }

}
