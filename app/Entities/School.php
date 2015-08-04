<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Entity {

    use SoftDeletes;

    public $timestamps = true;
    // Don't forget to fill this array
    protected $fillable = ['name', 'charter', 'route', 'phoneOne', 'phoneTwo', 'fax', 'address', 'town', 'token'];

    public function users() {
        return $this->belongsToMany(User::getClass());
    }

    public function userSchool($id) {
        return $this->belongsToMany(User::getClass(), 'school_user')->wherePivot('user_id', $id);
    }

    public function degrees() {
        return $this->belongsToMany(Degree::getClass(),'degree_school')->withPivot('id')->withTimestamps();
    }

    public function isValid($data) {
        $rules = [
            'name' => 'required',
            'charter' => 'required|unique:schools',
            'phoneOne' => 'required',
            'address' => 'required',
            'town' => 'required',
            'token' => 'required|unique:schools'];

        if ($this->exists) {
            $rules['charter'] .= ',charter,' . $this->id;
            $rules['token'] .= ',token,' . $this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
