<?php

namespace AccountHon\Repositories;

use AccountHon\Entities\Dues;

class DuesRepository Extends BaseRepository {
	
	 public function getModel() {
        return new Dues();
    }
}