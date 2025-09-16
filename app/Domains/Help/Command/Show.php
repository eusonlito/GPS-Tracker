<?php declare(strict_types=1);

namespace App\Domains\Help\Command;

use App\Domains\Help\ControllerApi\Service\Detail as DetailService;
use App\Domains\Help\ControllerApi\Service\Index as IndexService;

class Show extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'help:show {name?}';

    /**
     * @var string
     */
    protected $description = 'Show Base Help';

    /**
     * @return void
     */
    public function handle(): void
    {
        if ($name = $this->argument('name')) {
            $service = DetailService::new($name);
        } else {
            $service = IndexService::new();
        }

        $this->info(helper()->jsonEncode($service->data()));
    }
}
