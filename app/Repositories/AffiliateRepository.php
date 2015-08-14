<?php

namespace AccountHon\Repositories;

use AccountHon\Entities\Affiliate;

class AffiliateRepository Extends BaseRepository {
	
	 public function getModel() {
        return new Affiliate();
    }
}