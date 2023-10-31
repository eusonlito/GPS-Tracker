<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;

class Create extends CreateUpdateAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->request();
    }

    /**
     * @return void
     */
    protected function request(): void
    {
        $this->requestMergeWithRow([
            'user_id' => $this->user()->id,
            'timezone_id' => $this->timezoneId(),
        ]);
    }

    /**
     * @return int
     */
    protected function timezoneId(): int
    {
        return $this->cache(
            fn () => TimezoneModel::query()
                ->whereDefault()
                ->value('id')
        );
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCreateUpdate();
    }
}
