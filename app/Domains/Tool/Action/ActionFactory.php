<?php declare(strict_types=1);

namespace App\Domains\Tool\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;

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
