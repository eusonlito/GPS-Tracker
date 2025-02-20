<?php

declare(strict_types=1);

namespace App\Domains\Permissions\Feature\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\CoreApp\Model\ModelAbstract;

class Feature extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'features';

    /**
     * @const string
     */
    public const TABLE = 'features';
}