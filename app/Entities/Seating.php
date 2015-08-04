<?php

namespace AccountHon\Entities;




class Seating extends Entity
{


    protected $fillable = ['code', 'detail', 'date', 'amount',
        'status', 'catalog_id',  'accounting_period_id',
        'type_id','type_seat_id', 'user_created', 'user_updated', 'token'];

    public function catalogs(){
        return $this->belongsTo(Catalog::getClass(),'catalog_id','id');
    }
    public function catalogsPart(){
        return $this->belongsTo(Catalog::getClass(),'catalogPart_id','id');
    }
    public function types(){
        return $this->belongsTo(TypeForm::getClass(),'type_id','id');
    }
    public function typeSeat(){
        return $this->belongsTo(TypeSeat::getClass(),'type_seat_id','id');
    }
    public function accountingPeriods(){
        return $this->belongsTo(AccountingPeriod::getClass(),'accounting_period_id','id');
    }

    public function isValid($data) {
        $rules = [
            'code'=> 'required',
            'detail'=> 'required',
            'date'=> 'required',
            'amount'=> 'required',
            'status'=> 'required',
            'catalog_id'=> 'required',
            'accounting_period_id'=> 'required',
            'type_id'=> 'required',
            'type_seat_id'=> 'required',
            'token'=> 'required',
        ];
        
        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }


}
