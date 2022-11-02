<?php declare(strict_types=1);

namespace App\Domains\Timezone\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Geojson extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'overwrite' => ['bail', 'boolean'],
        ];
    }
}
