<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\Model;

class setting extends Model
{


    protected $fillable = ['catalog_id', 'type_seat_id','token'];

    public function catalogs() {
        return $this->belongsTo(Catalog::getClass(),'catalog_id','id');
    }

    public function typeSeat() {
        return $this->belongsTo(TypeSeat::getClass(),'type_seat_id','id');
    }

    public function isValid($data) {
        $rules = [
            'catalog_id' => 'required',
            'token' => 'required',
            'type_seat_id' => 'required'];


        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
