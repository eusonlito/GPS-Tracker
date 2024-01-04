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
    protected $description = 'Update All Positions with Empty City';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->factory()->action()->updateCityEmpty();

        $this->info('[END]');
    }
}
