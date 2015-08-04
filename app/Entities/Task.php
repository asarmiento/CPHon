<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Entity {

    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['name'];

    public function Users() {
        return $this->belongsToMany(User::getClass())->withPivot('status');
    }

    public function menus() {
        return $this->belongsToMany(Menu::getClass())->withPivot('status');
    }

    public function isValid($data) {
        $rules = ['name' => 'required'];


        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
