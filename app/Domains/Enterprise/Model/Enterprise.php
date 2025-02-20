<?php

declare(strict_types=1);

namespace App\Domains\Enterprise\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\User\Model\User;

class Enterprise extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'enterprises';

    /**
     * @const string
     */
    public const TABLE = 'enterprises';

    /**
     * Quan hệ: Một doanh nghiệp có nhiều Users
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'enterprise_id');
    }

    /**
     * Kiểm tra nếu một User thuộc doanh nghiệp này
     */
    public function hasUser(int $userId): bool
    {
        return $this->users()->where('id', $userId)->exists();
    }
}
