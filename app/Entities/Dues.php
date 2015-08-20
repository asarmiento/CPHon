<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\Model;

class Dues extends Entity
{
    protected $table = "affiliate_record_percentage";

    public function Affiliates()
    {
        return $this->belongsTo(Dues::getClass(),'Affiliate_id','id');
    }
}
