<?php
namespace AccountHon\Repositories;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use AccountHon\Entities\Menu;
/**
 * Description of MenuRepository
 *
 * @author Anwar Sarmiento
 */
class MenuRepository extends BaseRepository {
    public function getModel() {
        return new menu();
    }
    public function listsMenu() {
    	return $this->newQuery()->lists('id');
    }

//put your code here
}
