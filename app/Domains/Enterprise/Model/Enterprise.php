<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;

    protected $table = 'enterprises';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone_number',
        'email',
        'owner_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
