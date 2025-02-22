<?php

namespace App\Domains\Enterprise\Service;

use App\Domains\Enterprise\Model\Enterprise;

class EnterpriseService
{
    private Enterprise $enterprise;

    // constructor
    public function __construct(Enterprise $enterprise)
    {
        $this->enterprise = $enterprise;
    }

    public static function getAll(): array
    {
        return Enterprise::with('ownerRole')
            ->get()
            ->map(function ($enterprise) {
                return [
                    'id' => $enterprise->id,
                    'name' => $enterprise->name,
                    'email' => $enterprise->email,
                    'roleName' => $enterprise->ownerRole->name ?? null,
                ];
            })
            ->toArray();
    }
}
