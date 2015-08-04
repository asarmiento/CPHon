<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Degree extends Entity
{
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['code','name', 'token'];

    /**
     * @return $this
     */
    public function schools() {
        return $this->belongsToMany(School::getClass())->withPivot('id','created_at','updated_at')->withTimestamps();
    }

    public function whereSchools($data,$id){

        return $this->belongsToMany(School::getClass(),'degree_school')->wherePivot($data,$id);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auxiliarySeats() {
        return $this->hasMany(AuxiliarySeat::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function costs() {
        return $this->belongsTo(Cost::getClass());
    }
    public function isValid($data) {
        $rules = ['name' => 'required',
            'code'=>'required',
            'token'=>'required'
        ];

        if ($this->exists) {
            $rules['name'] .= ',name,' . $this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
