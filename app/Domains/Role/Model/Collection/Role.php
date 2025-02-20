<?php

namespace App\Domains\Role\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\Role\Model\Traits\QueryFilter;
use App\Domains\CoreApp\Model\ModelAbstract;

class Role extends ModelAbstract
{
    use HasFactory;
    use QueryFilter;
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    protected $table = 'roles';

    public const TABLE = 'roles';

    protected $fillable = [
        'name',
        'enterprise_id',
        'description',
        'highest_privilege_role'
    ];
}
