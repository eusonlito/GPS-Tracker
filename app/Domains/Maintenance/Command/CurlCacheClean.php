<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Command;

class CurlCacheClean extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'maintenance:curl:cache:clean';

    /**
     * @var string
     */
    protected $description = 'Delete expired curl cache files';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('START');

        $this->factory()->action()->curlCacheClean();

        $this->info('END');
    }
}
