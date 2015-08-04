<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourtCase extends Model
{
    use SoftDeletes;

    protected $fillable = ['date', 'type_seat_id', 'token', 'abbreviation'];

    public function seatings(){
        return $this->hasMany(Seating::getClass(),'code','abbreviation');
    }

    public function isValid($data) {
        $rules = ['date' => 'required',
            'type_seat_id' => 'required',
            'token' => 'required',
            'abbreviation' => 'required'];

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
