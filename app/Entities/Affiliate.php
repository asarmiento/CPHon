<?php

namespace AccountHon\Entities;



class Affiliate extends Entity
{
     public $timestamps = true;
    // Don't forget to fill this array
    protected $fillable = [ `code`, `charter`, `fname`, `sname`, `flast`, `slast`, 
    `address`, `homePhone`, `workPhone`, `job`, `affiliation`, `birthdate`, 
    `retirementDate`, `salary`, `observation`, `maritalStatus`, `sex`, `office`, `status`,'token'];

	public function RecordPercentages()
    {
        return $this->belongsTo(RecordPercentage::getClass())->withPivot('amount_affiliate','amount','consecutive');
    }

     
}
