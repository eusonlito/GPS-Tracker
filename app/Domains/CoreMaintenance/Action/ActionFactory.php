<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @return void
     */
    public function curlCacheClean(): void
    {
        $this->actionHandle(CurlCacheClean::class);
    }

    /**
     * @return void
     */
    public function domainCreate(): void
    {
        $this->actionHandle(DomainCreate::class, $this->validate()->domainCreate());
    }

    /**
     * @return void
     */
    public function directoryEmptyDelete(): void
    {
        $this->actionHandle(DirectoryEmptyDelete::class, $this->validate()->directoryEmptyDelete());
    }

    /**
     * @return void
     */
    public function fileDeleteOlder(): void
    {
        $this->actionHandle(FileDeleteOlder::class, $this->validate()->fileDeleteOlder());
    }

    /**
     * @return void
     */
    public function fileZip(): void
    {
        $this->actionHandle(FileZip::class, $this->validate()->fileZip());
    }

    /**
     * @return void
     */
    public function mailTestQueue(): void
    {
        $this->actionHandle(MailTestQueue::class, $this->validate()->mailTestQueue());
    }

    /**
     * @return void
     */
    public function mailTestSend(): void
    {
        $this->actionHandle(MailTestSend::class, $this->validate()->mailTestSend());
    }

    /**
     * @return void
     */
    public function migrationClean(): void
    {
        $this->actionHandle(MigrationClean::class);
    }

    /**
     * @return array
     */
    public function opcachePreload(): array
    {
        return $this->actionHandle(OpcachePreload::class);
    }
}
