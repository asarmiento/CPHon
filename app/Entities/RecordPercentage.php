<?php

namespace AccountHon\Entities;

class RecordPercentage extends Entity
{
    public $timestamps = true;
    // Don't forget to fill this array
    protected $fillable = ['year', 'month', 'percentage_affiliates', 'percentage','token'];

    public function Affiliates()
    {
        return $this->belongsToMany(Affiliate::getClass())->withPivot('amount_affiliate','amount','consecutive');
    }
}