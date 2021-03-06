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

    public function isValid($data) {
        $rules = ['year'=>'required|numeric', 
            'month'=>'required|numeric', 'percentage_affiliates'=>'required|numeric', 
            'percentage'=>'required|numeric','token'=>'required'];


        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}