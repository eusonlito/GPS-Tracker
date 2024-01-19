<?php declare(strict_types=1);

namespace App\Services\Protocol\Resource;

class Command extends ResourceAbstract
{
    /**
     * @return array
     */
    protected function attributesAvailable(): array
    {
        return ['body', 'serial', 'type', 'payload', 'data', 'response'];
    }

    /**
     * @return string
     */
    public function format(): string
    {
        return 'command';
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->serial()
            && $this->type();
    }

    /**
     * @return string
     */
    public function body(): string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return string
     */
    public function serial(): string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return ?array
     */
    public function payload(): ?array
    {
        return $this->attribute(__FUNCTION__);
    }

    /**
     * @return string
     */
    public function response(): string
    {
        return $this->attribute(__FUNCTION__);
    }
}
