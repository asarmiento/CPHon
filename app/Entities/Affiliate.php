<?php

namespace AccountHon\Entities;



class Affiliate extends Entity
{
     public $timestamps = true;
    // Don't forget to fill this array
    protected $fillable = [
    'code',
    'charter',
    'fname', 
    'sname',
    'flast',
    'slast',
    'address',
    'homePhone',
    'workPhone',
    'job',
    'affiliation', 'birthdate', 
    'retirementDate', 'salary', 'observation', 'maritalStatus', 'sex', 'office', 'status','token'];

	public function RecordPercentages()
    {
        return $this->belongsToMany(RecordPercentage::getClass())->withPivot('amount_affiliate','amount','consecutive');
    }

     public function isValid($data) {
        $rules = ['code'=>'required', 'charter'=>'required', 
            'fname'=>'required', 'flast'=>'required', 
    'address'=>'required', 
    'homePhone'=>'required',
    'affiliation'=>'required', 'birthdate'=>'required', 
  	'maritalStatus'=>'required', 'status'=>'required','token'=>'required'];

       $validator = \Validator::make($data, $rules);
       
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
