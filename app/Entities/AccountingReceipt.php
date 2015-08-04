<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class AccountingReceipt extends Entity {

    use SoftDeletes;
    protected $fillable = ['date', 'receipt_number', 'received_from', 'detail', 'amount', 'catalog_id', 'status', 'type_seat_id', 'accounting_period_id', 'token', 'user_created', 'user_updated'];

    public function catalogs() {
        return $this->belongsTo(Catalog::getClass(),'catalog_id','id');
    }

    public function typeSeats() {
        return $this->belongsTo(TypeSeat::getClass(),'type_seat_id','id');
    }

    public function accountingPeriods() {
        return $this->belongsTo(AccountingPeriod::getClass(),'accounting_period_id','id');
    }

    public function notes() {
        return $this->belongsTo(Note::getClass());
    }

    public function courtCases() {
        return $this->belongsTo(CourtCase::getClass());
    }

    public function deposits() {
        return $this->belongsTo(Deposit::getClass());
    }

    public function paymentFrom() {
        return $this->belongsTo(PaymentFrom::getClass());
    }

    public function isValid($data) {
        $rules = [
            'date'                 => 'required',
            'receipt_number'       => 'required',
            'received_from'        => 'required',
            'detail'               => 'required',
            'amount'               => 'required',
            'catalog_id'           => 'required',
            'status'               => 'required',
            'type_seat_id'         => 'required',
            'accounting_period_id' => 'required',
            'token'                => 'required'
        ];


        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
// 'date'                = ok
// 'receipt_number'      = ok
// 'received_from'       = ok
// 'detail'              = ok
// 'amount'              = ok
// 'line'                = //se genera
// 'catalog_id'          = ok
// 'type_seat_id         = ok
// 'accounting_period_id = ok
// 'note_id              = // null por mientras - hasta que venga Anwar
// 'court_case_id        = // null por mientras
// 'deposit_id           = // null - ya no debería existir porque se aplica al deposito y no al recibo
// 'payment_from_id      = // null - ya no debería existir porque se aplica al deposito y no al recibo
// 'token                = // se genera
// 'user_created         = ok
// 'user_updated         = // null por mientras
