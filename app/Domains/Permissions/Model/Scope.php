<?php declare(strict_types=1);

namespace App\Domains\Permissions\Model;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    protected $table = 'scopes';

    protected $fillable = [
        'name',
        'description',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'scope_id');
    }
}
