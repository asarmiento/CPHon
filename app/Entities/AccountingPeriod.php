<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class AccountingPeriod extends Entity {

    use SoftDeletes;

    protected $fillable = ['month', 'year', 'school_id', 'token', 'period', 'user_created', 'user_updated'];
    
    public function schools()
    {
        return $this->belongsTo(School::getClass());
    }

    /**
     * @return mixed
     */
    public function seatings()
    {
        /** @var TYPE_NAME $this */
        return $this->hasMany(Seating::getClass());
    }
    
    public function templateSeatings()
    {
        return $this->hasMany(TemplateSeating::getClass());
    }
    
    public function accountingReceipts()
    {
        return $this->hasMany(AccountingReceipts::getClass());
    }
    
    public function checks()
    {
        return $this->hasMany(Check::getClass());
    }
    
    public function auxiliaryReceipts()
    {
        return $this->hasMany(AuxiliaryReceipt::getClass());
    }
    
    public function auxiliarySeats()
    {
        return $this->hasMany(AuxiliarySeat::getClass());
    }
    
    public function templateAuxiliarySeats()
    {
        return $this->hasMany(TemplateAuxiliarySeat::getClass());
    }
    public function isValid($data) {
        $rules = ['month' => 'required',
            'year'=>'required',
            'school_id'=>'required',
            'token'=>'required'
        ];

       $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

    public function period(){
        return $this->month. ' - ' . $this->year;
    }
}
