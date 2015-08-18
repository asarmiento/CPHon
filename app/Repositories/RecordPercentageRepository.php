<?php

namespace AccountHon\Repositories;

use AccountHon\Entities\RecordPercentage;

class RecordPercentageRepository extends BaseRepository{

	 public function getModel() {
        return new RecordPercentage();
    }
}
