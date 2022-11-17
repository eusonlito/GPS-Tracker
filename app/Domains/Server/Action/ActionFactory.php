<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @return void
     */
    public function manifestGenerate(): void
    {
        $this->actionHandle(ManifestGenerate::class);
    }
}
