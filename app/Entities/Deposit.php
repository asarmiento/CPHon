<?php

namespace AccountHon\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Entity
{
    use SoftDeletes;
    protected $fillable = ['number', 'date', 'account', 'amount', 'token', 'codeReceipt','school_id'];
    public function isValid($data) {
        $rules = [
            'number'=> 'required',
            'date'=> 'required',
            'account'=> 'required',
            'amount'=> 'required',
            'token'=> 'required',
            'school_id'=> 'required',
            'codeReceipt'=> 'required',
       ];
        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
