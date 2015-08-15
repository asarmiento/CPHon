<?php

namespace AccountHon\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class User extends Entity implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'last', 'email', 'password', 'type_user_id', 'token'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     *  Inicio Relaciones.
     */
    /* Relacion con la tabla Tipo de usuarios */

    public function typeUsers() {
        return $this->belongsTo(TypeUser::getClass(), 'type_user_id', 'id');
    }

    public function tasks() {
        return $this->belongsToMany(Task::getClass())->withPivot('status', 'menu_id');
    }

    public function menus() {
        return $this->belongsToMany(Menu::getClass(), 'task_user')->withPivot('status', 'task_id')->orderBy('priority', 'asc')->orderBy('name', 'asc');
    }

    /* Relacion con la tabla schools */

    public function schools() {
        return $this->belongsToMany(School::getClass());
    }

    /**
     * Fin Relaciones.
     */
 
    /* creacion de string del id de schools */

    public function idSchools($schools) {
        if ($schools):
            $id = '';
            foreach ($schools as $school):
                $id .= $school->id . ',';

            endforeach;
            $id = substr($id, 0, -1);

            return $id;
        endif;

        return false;
    }

    /* creacion de string del name de schools */

    public function nameSchools($schools) {
        if ($schools):
            $name = '';
            foreach ($schools as $school):
                $name .= $school->name . ',';

            endforeach;
            $name = substr($name, 0, -1);

            return $name;
        endif;

        return false;
    }

    /* validacion de los campos del usuario */

    public function isValid($data) {
        $rules = ['email' => 'required|unique:users',
            'name' => 'required',
            'last' => 'required',
            'password' => 'required|min:8|alpha_dash',
            'type_users_id' => 'required',];

        if ($this->exists) {
            $rules['email'] .= ',email,' . $this->id;
            $rules['password'] .= ',password,' . $this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->fails()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }



    public function is($type) {
        return $this->typeUsers->id === $type;
    }

    public function admin() {
        return $this->typeUsers->id === 1;
    }
    public function nameComplete(){
        return $this->name.' '.$this->last;
    }

    /*public function validate($password){
        if($password == \Auth::user()->password){
            return true;
        }
        return false;
    }*/
}
