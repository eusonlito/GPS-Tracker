<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'description'];

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }
}
