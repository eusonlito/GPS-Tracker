<?php declare(strict_types=1);

namespace App\Domains\Permissions\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Permissions\Model\Role;  // Thêm dòng này
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
}

// namespace App\Domains\Permissions\Model;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use App\Domains\Permissions\Model\Traits\TypeFormat as TypeFormatTrait;
// use App\Domains\CoreApp\Model\ModelAbstract;

// class Permission extends ModelAbstract
// {
//     use HasFactory;
//     use TypeFormatTrait;

//     /**
//      * @var string
//      */
//     protected $table = 'permissions';

//     /**
//      * @const string
//      */
//     public const TABLE = 'permissions';
// }