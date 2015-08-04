<?php

namespace AccountHon\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;

class AuxiliaryReceipt extends Entity
{
    use SoftDeletes;
    protected $fillable = ['date', 'receipt_number', 'received_from', 'detail', 'amount', 'line','status',
        'financial_record_id', 'type_seat_id', 'accounting_period_id', 'note_id', 'court_case_id',
        'deposit_id','payment_from_id', 'token', 'user_created', 'user_updated'];
   
    public function financialRecords() {
        return $this->belongsTo(FinancialRecords::getClass(), 'financial_record_id','id');
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
            'date'=> 'required',
            'receipt_number'=> 'required',
            'received_from'=> 'required',
            'detail'=> 'required',
            'amount'=> 'required',
            'financial_record_id'=> 'required',
            'type_seat_id'=> 'required',
            'accounting_period_id'=> 'required',
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
//'date' - Viene del backend - no editable
//'receipt_number' - Viene del backend - no editable
//'received_from' - Llenado por el usuario
//'detail' - LLenado por el usuario
//'amount' - LLenado por el usuario
//'line' - solo backend
//'financial_record_id' - LLenado por el usuario
//'type_seat_id' - No va
//'accounting_period_id' - Viene del backend - no editable
//'note_id' - Escogido por el usuario -- No va
//'court_case_id' - No va por mientras
//'deposit_id' - 
//'payment_from_id' - Muchos métodos de pago con monto
