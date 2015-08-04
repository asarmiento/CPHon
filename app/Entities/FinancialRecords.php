<?php

namespace AccountHon\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialRecords extends Entity
{
    use SoftDeletes;
    protected $fillable = ['student_id','year','cost_id','monthly_discount','tuition_discount','token','balance','user_created', 'user_updated'];

    public function students() {
        return $this->belongsTo(Student::getClass(),'student_id','id');
    }

    public function costs(){
        return $this->belongsTo(Cost::getClass(),'cost_id','id');
    }

    public function degreeDatos(){
        return $this->costs->degreeSchool->degrees;
    }

    public function isValid($data) {
        $rules = [
            'student_id'=> 'required',
            'year'=> 'required',
            'cost_id'=> 'required',
            'balance'=> 'required'
        ];


        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
