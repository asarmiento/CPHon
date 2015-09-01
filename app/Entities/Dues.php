<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Dues extends Entity
{
    protected $table = "affiliate_record_percentage";

	public $timestamps = true;

    public $fillable=['affiliate_id','record_percentage_id','amount_affiliate','amount','token','salary','consecutive','date_payment', 'date_dues'];
    
    public function affiliates()
    {
        return $this->belongsTo(Affiliate::getClass(),'affiliate_id','id')->orderBy('id','DESC');
    }

    public function monthDue()
    {
    	$date_payment = Carbon::parse($this->date_payment)->format('d/m/Y');
    	$arr_date_payment = explode("/", $date_payment);
    	return ( intval($arr_date_payment[1]) -1 );
    }

    public function yearDue()
    {
    	$date_payment = Carbon::parse($this->date_payment)->format('d/m/Y');
    	$arr_date_payment = explode("/", $date_payment);
    	return $arr_date_payment[2];
    }

    public function dateDues()
    {
    	return Carbon::parse($this->date_dues)->format('d/m/Y');
    }

}
