<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Entity
{
    
    use SoftDeletes;

    public $timestamps = true;
    // Don't forget to fill this array
    protected $fillable = ['date','description','type_id','token'];
    
    public function typeForms() {
        return $this->hasMany(TypeForm::getClass(),'id','type_id');
    }

    public function isValid($data) {
        $rules = ['date' => 'required'];

        if ($this->exists) {
            $rules['date'] .= ',date,' . $this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
