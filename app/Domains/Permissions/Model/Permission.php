<?php declare(strict_types=1);

namespace App\Domains\Permissions\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Role\Model\Role;  // Thêm dòng này
use App\Domains\Permissions\Model\Action;
use App\Domains\Permissions\Model\Entity;
use App\Domains\Permissions\Model\Scope;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'role_id',
        'action_id',
        'entity_id',
        'enterprise_id',
        'scope_id',
        'entity_record_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Domains\User\Model\User::class, 'user_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    public function scope()
    {
        return $this->belongsTo(Scope::class, 'scope_id');
    }
    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    // Thêm accessor để lấy name từ role
    public function getNameAttribute(): ?string
    {
        return $this->role ? $this->role->name : null;
    }
}

