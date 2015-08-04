<?php

namespace AccountHon\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Entity
{
    use SoftDeletes;
    // Don't forget to fill this array
    protected $fillable = ['name', 'url', 'icon_font'];

    public function Tasks()
    {
        return $this->belongsToMany(Task::getClass())->withPivot('status');
    }

    public function tasksActive($user)
    {
        return $this->belongsToMany(Task::getClass(), 'task_user')->wherePivot('status', 1)->wherePivot('user_id', $user);
    }

    public function isValid($data)
    {
        $rules = ['name' => 'required|unique:menus',
            'url' => 'required|unique:menus',
            'icon_font' => 'required' ];

        if ($this->exists) {
            $rules['name'] .= ',name,'.$this->id;
            $rules['url'] .= ',url,'.$this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
