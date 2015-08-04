<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentFrom extends Entity {

    public $timestamps = true;

    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['name'];

    public function accountingReceipt() {
        return $this->hasMany(AccountingReceipt::getClass());
    }

    public function auxiliaryReceipt() {
        return $this->hasMany(AuxiliaryReceipt::getClass());
    }

    public function isValid($data) {
        $rules = ['name' => 'required|unique:payment_froms'];

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
