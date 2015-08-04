<?php

namespace AccountHon\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Entity
{
    use SoftDeletes;
    protected $fillable = ['year', 'monthly_payment', 'tuition', 'shares', 'degree_school_id',  'token', 'user_created', 'user_updated'];

    public function degreeSchool() {
        return $this->belongsTo(DegreeSchool::getClass(),'degree_school_id','id');
    }

    public function financialRecords() {
        return $this->hasMany(FinancialRecords::getClass());
    }
    public function isValid($data) {
        $rules = ['year' => 'required',
            'monthly_payment' => 'required',
            'tuition' => 'required',
         //   'shares' => 'required',
            'token' => 'required',
            'degree_school_id' => 'required'];

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
