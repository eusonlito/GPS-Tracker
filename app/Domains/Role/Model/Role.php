<?php

declare(strict_types=1);

namespace App\Domains\Role\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\Role\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\CoreApp\Model\ModelAbstract;

class Role extends ModelAbstract
{
    use HasFactory;
    use TypeFormatTrait;

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @const string
     */
    public const TABLE = 'roles';
}
