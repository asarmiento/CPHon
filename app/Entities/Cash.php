<?php

namespace AccountHon\Entities;


class Cash extends Entity
{
    protected $fillable = ['amount', 'receipt','school_id'];
    public function isValid($data) {
        $rules = [
            'amount'=> 'required',
            'receipt'=> 'required',
            'school_id'=>'required'
         ];
        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
