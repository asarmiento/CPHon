<?php
namespace AccountHon\Repositories;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use AccountHon\Entities\PaymentFrom;
/**
 * Description of PaymentFromRepository
 *
 * @author Anwar Sarmiento
 */
class PaymentFromRepository extends BaseRepository {
    public function getModel() {
        return new PaymentFrom();
    }

//put your code here
}
