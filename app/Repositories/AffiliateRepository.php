<?php

namespace AccountHon\Repositories;


class AffiliateRepository Extends BaseRepository {
	
	 public function getModel() {
        return new Affiliate();
    }
}