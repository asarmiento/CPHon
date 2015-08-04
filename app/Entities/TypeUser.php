<?php

namespace AccountHon\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class TypeUser extends Entity {
    /*
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'type_users';

    use SoftDeletes;

    public $timestamps = true;
    // Don't forget to fill this array
    protected $fillable = ['name'];

    public function users() {
        return $this->belongsTo(User::getClass());
    }

    public function isValid($data) {
        $rules = ['name' => 'required|unique:type_users'];

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
