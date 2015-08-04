<?php

namespace AccountHon\Entities;



use Illuminate\Database\Eloquent\SoftDeletes;

class Catalog extends Entity
{
    use SoftDeletes;

    protected $fillable = ['code', 'name', 'style', 'note',
        'type', 'level', 'school_id',
        'catalog_id','catalogPart_id','token', 'user_created', 'user_updated'];

    public function catalogs(){
        return $this->belongsTo(Catalog::getClass());
    }

    public function schools(){
        return $this->belongsTo(School::getClass());
    }

    public function isValid($data) {
        $rules = [
            'code'=> 'required',
            'name'=> 'required',
            'style'=> 'required',
            'note'=> 'required',
            'type'=> 'required',
            'level'=> 'required',
            'school_id'=> 'required',
            'catalog_id'=> 'required',
            'token'=> 'required',
        ];
        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

    public function codeName(){
        return $this->code.' - '.$this->name;
    }
}
