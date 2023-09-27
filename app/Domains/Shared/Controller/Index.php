<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Http\Response;
use App\Domains\Shared\Service\Controller\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @param string $slug = ''
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $slug = ''): Response
    {
        $this->check($slug);

        $this->meta('title', __('shared-index.meta-title'));

        return $this->page('shared.index', $this->data());
    }

    /**
     * @param string $slug
     *
     * @return void
     */
    protected function check(string $slug): void
    {
        if (app('configuration')->bool('shared_enabled') === false) {
            abort(404);
        }

        if (app('configuration')->string('shared_slug') !== $slug) {
            abort(404);
        }
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request)->data();
    }
}
