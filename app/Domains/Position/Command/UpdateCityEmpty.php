<?php declare(strict_types=1);

namespace App\Domains\Position\Command;

class UpdateCityEmpty extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'position:update:city:empty';

    /**
     * @var string
     */
    protected $description = 'Update Positions with City when Empty';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->factory()->action()->updateCityEmpty();

        $this->info('[END]');
    }
}
