<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\Model;

class TemplateAuxiliarySeat extends Model
{
    protected $fillable = ['date', 'code', 'detail', 'amount',
        'financial_record_id', 'type_seat_id', 'accounting_period_id',
        'type_id', 'token', 'user_created', 'user_updated'];

    public function financialRecords() {
        return $this->belongsTo(FinancialRecords::getClass());
    }

    public function typeSeats() {
        return $this->belongsTo(TypeSeat::getClass());
    }

    public function accountingPeriods() {
        return $this->belongsTo(AccountingPeriod::getClass());
    }

    public function types() {
        return $this->belongsTo(TypeForm::getClass());
    }
}
