<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\Model;

class Dues extends Entity
{
    protected $table = "affiliate_record_percentage";

    public function affiliates()
    {
        return $this->belongsTo(Affiliate::getClass(),'affiliate_id','id')->orderBy('id','DESC');
    }
}
