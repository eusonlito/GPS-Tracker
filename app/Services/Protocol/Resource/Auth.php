<?php declare(strict_types=1);

namespace App\Services\Protocol\Resource;

class Auth extends ResourceAbstract
{
    /**
     * @return array
     */
    protected function attributesAvailable(): array
    {
        return ['body', 'serial', 'data', 'response'];
    }

    /**
     * @return string
     */
    public function format(): string
    {
        return 'auth';
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return boolval($this->serial());
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
    public function response(): string
    {
        return $this->attribute(__FUNCTION__);
    }
}
