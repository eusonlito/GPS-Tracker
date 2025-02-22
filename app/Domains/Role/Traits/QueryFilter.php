<?php

namespace App\Domains\Role\Model\Traits;

trait QueryFilter
{
    public function scopeById($query, int $id)
    {
        return $query->where('id', $id)->firstOrFail();
    }

    public function scopeByEnterpriseId($query, int $enterpriseId)
    {
        return $query->where('enterprise_id', $enterpriseId);
    }

    public function scopeEnabled($query)
    {
        return $query->where('highest_privilege_role', 0);
    }
}
