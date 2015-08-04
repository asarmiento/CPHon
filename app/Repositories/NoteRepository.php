<?php

namespace AccountHon\Repositories;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use AccountHon\Entities\Note;

/**
 * Description of NoteRepository
 *
 * @author Anwar Sarmiento
 */
class NoteRepository extends BaseRepository {

    /**
     * @return Note
     */
    public function getModel() {
        return new Note();
    }

//put your code here
}
