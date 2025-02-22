<?php

namespace App\Domains\Enterprise\Model;

use App\Domains\Role\Model\Role;
use App\Domains\Core\Model\ModelAbstract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Enterprise extends ModelAbstract
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

    /** Một Enterprise thuộc về một Role */
    public function ownerRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'owner_id');
    }

    /** Một Enterprise cos nhiều Role */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /** Kiểm tra Enterprise có Role cụ thể hay không */
    public function hasRole($role): bool
    {
        return $this->roles->contains('name', $role);
    }
}
