<?php
namespace AccountHon\Repositories;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use AccountHon\Entities\Bank;
/**
 * Description of BankRepository
 *
 * @author Anwar Sarmiento
 */
class BankRepository extends BaseRepository {
    public function getModel() {
        return new Bank();
    }


}
