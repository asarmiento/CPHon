<?php

namespace AccountHon\Entities;



use Illuminate\Database\Eloquent\SoftDeletes;

class DegreeSchool extends Entity
{
    use SoftDeletes;

    public $table = 'degree_school';
    public $timestamps = true;

    public function degrees(){
        return $this->belongsTo(Degree::getClass(),'degree_id','id');
    }
}
