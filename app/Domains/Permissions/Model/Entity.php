<?php declare(strict_types=1);

namespace App\Domains\Permissions\Model;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $table = 'entities';

    protected $fillable = [
        'enterprise_id',
        'name',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'entity_id');
    }
}
