<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class View extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->blade();
        $this->pagination();
    }

    /**
     * @return void
     */
    protected function blade(): void
    {
        Blade::directive('arrayAsBadges', function (string $expression) {
            return "<?= \App\Services\Html\Html::arrayAsBadges($expression); ?>";
        });

        Blade::directive('arrayAsText', function (string $expression) {
            return "<?= \App\Services\Html\Html::arrayAsText($expression); ?>";
        });

        Blade::directive('asset', function (string $expression) {
            return "<?= \App\Services\Html\Html::asset($expression); ?>";
        });

        Blade::directive('cut', function (string $expression) {
            return "<?= \App\Services\Html\Html::cut($expression); ?>";
        });

        Blade::directive('dateLocal', function (string $expression) {
            return "<?= helper()->dateLocal($expression); ?>";
        });

        Blade::directive('dateWithTimezone', function (string $expression) {
            return "<?= \App\Services\Html\Html::dateWithTimezone($expression); ?>";
        });

        Blade::directive('dateWithUserTimezone', function (string $expression) {
            return "<?= \App\Services\Html\Html::dateWithUserTimezone($expression); ?>";
        });

        Blade::directive('distanceHuman', function (string $expression) {
            return "<?= helper()->distanceHuman($expression); ?>";
        });

        Blade::directive('icon', function (string $expression) {
            return "<?= \App\Services\Html\Html::icon($expression); ?>";
        });

        Blade::directive('image', function (string $expression) {
            return "<?= \App\Services\Html\Html::image($expression); ?>";
        });

        Blade::directive('inline', function (string $expression) {
            return "<?= \App\Services\Html\Html::inline($expression); ?>";
        });

        Blade::directive('money', function (string $expression) {
            return "<?= helper()->money($expression); ?>";
        });

        Blade::directive('number', function (string $expression) {
            return "<?= helper()->number($expression); ?>";
        });

        Blade::directive('progressbar', function (string $expression) {
            return "<?= \App\Services\Html\Html::progressbar($expression); ?>";
        });

        Blade::directive('query', function (string $expression) {
            return "<?= helper()->query($expression); ?>";
        });

        Blade::directive('sizeHuman', function (string $expression) {
            return "<?= helper()->sizeHuman($expression); ?>";
        });

        Blade::directive('status', function (string $expression) {
            return "<?= \App\Services\Html\Html::status($expression); ?>";
        });

        Blade::directive('svg', function (string $expression) {
            return "<?= \App\Services\Html\Html::svg($expression); ?>";
        });

        Blade::directive('timeHuman', function (string $expression) {
            return "<?= helper()->timeHuman($expression); ?>";
        });

        Blade::directive('unit', function (string $expression) {
            return "<?= helper()->unit($expression); ?>";
        });

        Blade::directive('unitHuman', function (string $expression) {
            return "<?= helper()->unitHuman($expression); ?>";
        });

        Blade::directive('unitHumanRaw', function (string $expression) {
            return "<?= helper()->unitHumanRaw($expression); ?>";
        });
    }

    /**
     * @return void
     */
    protected function pagination(): void
    {
        Paginator::defaultView('molecules.pagination');
    }
}
