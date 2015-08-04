<?php

namespace AccountHon\Entities;


class BalancePeriod extends Entity
{
    protected $table='balance_periods';

    protected $fillable = [ 'amount', 'catalog_id', 'period', 'year','school_id'];

    public function isValid($data) {
        $rules = [
            'amount'=> 'required',
            'catalog_id'=> 'required',
            'period'=> 'required',
            'amount'=> 'required',
            'year'=> 'required'
        ];

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
