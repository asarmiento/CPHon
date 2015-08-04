<?php

namespace AccountHon\Entities;



use Illuminate\Database\Eloquent\SoftDeletes;

class AuxiliarySeat extends Entity {

    use SoftDeletes;
    protected $fillable = ['date', 'code', 'detail', 'amount',
        'financial_records_id', 'type_seat_id', 'accounting_period_id',
        'type_id','token', 'status', 'user_created', 'user_updated'];

    public function financialRecords() {
        return $this->belongsTo(FinancialRecords::getClass());
    }

    public function typeSeats() {
        return $this->belongsTo(TypeSeat::getClass(),'type_seat_id','id');
    }

    public function accountingPeriods() {
        return $this->belongsTo(AccountingPeriod::getClass(),'accounting_period_id','id');
    }

    public function types() {
        return $this->belongsTo(TypeForm::getClass(),'type_id','id');
    }
    public function isValid($data) {
        $rules = [
            'date'=> 'required',
            'code'=> 'required',
            'detail'=> 'required',
            'amount'=> 'required',
            'financial_records_id'=> 'required',
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
//date -> hoy()
//code -> automático - typeSeat ( se calcula en el backend - ASA )
//detail -> 
//amount -> 
//financial_recor_id -> Student
//type_seat_id -> no va
//accouting_period_id -> sin edición (viene del backend)
//type_id -> (debito o credito)
