<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\Model;

class Dues extends Entity
{

    protected $table = "affiliate_record_percentage";

	public $timestamps = true;

    public $fillable=['affiliate_id','record_percentage_id','amount_affiliate','amount','token','salary','consecutive','date_payment'];
    
    public function affiliates()
    {
        return $this->belongsTo(Affiliate::getClass(),'affiliate_id','id')->orderBy('id','DESC');
    }

}
