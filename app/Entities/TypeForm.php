<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class TypeForm extends Entity {

    use SoftDeletes;
    protected $table = 'types';
    protected $fillable = ['name', 'token'];

    public function notes() {
        return $this->hasMany(Note::getClass());
    }

    public function auxiliarySeats() {
        return $this->hasMany(AuxiliarySeat::getClass());
    }

    public function templateAuxiliarySeats() {
        return $this->hasMany(TemplateAuxiliarySeat::getClass());
    }

    public function auxiliaryReceipts() {
        return $this->hasMany(AuxiliaryReceipt::getClass());
    }

    public function seatings() {
        return $this->hasMany(Seating::getClass());
    }

    public function templateSeatings() {
        return $this->hasMany(TemplateSeating::getClass());
    }

    public function accountingReceipts() {
        return $this->hasMany(AuxiliaryReceipt::getClass());
    }

    public function isValid($data) {
        $rules = ['name' => 'required|unique:types'];

        if ($this->exists) {
            $rules['name'] .= ',name,' . $this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
