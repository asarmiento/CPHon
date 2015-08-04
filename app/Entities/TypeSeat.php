<?php

namespace AccountHon\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;

class TypeSeat extends Entity
{
    use SoftDeletes;
    public $timestamps = true;
    // Don't forget to fill this array
    protected $fillable = ['abbreviation', 'name','quatity', 'year', 'school_id', 'token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seatings() {
        return $this->hasMany(Seating::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schools(){
        return $this->belongsTo(School::getClass(),'school_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function templateSeatings() {
        return $this->hasMany(TemplateSeating::getClass());
    }

    /**
     * @return string
     */
    public function abbreviation(){
        return $this->abbreviation.'-'.$this->quatity;
    }
    public function isValid($data) {
        $rules = ['abbreviation' => 'required', 
                'name' => 'required',
                'quatity' => 'required',
                'year' => 'required',
                'school_id' => 'required',
                'token' => 'required'
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
