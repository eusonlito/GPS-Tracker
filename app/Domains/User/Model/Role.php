<?php

namespace App\Domains\User\Model;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    // use SoftDeletes;

    // protected $keyType = 'string';
    // public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'enterprise_id'
    ];
}
