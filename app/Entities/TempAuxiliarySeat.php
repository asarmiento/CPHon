<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempAuxiliarySeat extends Model
{
    use SoftDeletes;
    protected $fillable = ['date', 'code', 'detail', 'amount',
        'financial_records_id', 'type_seat_id', 'period',
        'type_id','token', 'status', 'user_created', 'user_updated'];

    public function isValid($data) {
        $rules = [
            'date'=> 'required',
            'code'=> 'required',
            'detail'=> 'required',
            'amount'=> 'required',
            'financial_records_id'=> 'required',
            'type_seat_id'=> 'required',
            'period'=> 'required',
            'type_id'=> 'required',
            'token'=> 'required',
            'status'=> 'required',
            'type_seat_id'=> 'required'
        ];


        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }


}
