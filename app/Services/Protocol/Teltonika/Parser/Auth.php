<?php declare(strict_types=1);

namespace App\Services\Protocol\Teltonika\Parser;

use App\Services\Protocol\ParserAbstract;

class Auth extends ParserAbstract
{
    /**
     * @return array
     */
    public function resources(): array
    {
        if ($this->bodyIsValid() === false) {
            return [];
        }

        $this->addIfValid($this->resourceAuth());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function bodyIsValid(): bool
    {
        return $this->bodyIsValidLength()
            && $this->bodyIsValidStart()
            && $this->bodyIsValidSerial();
    }

    /**
     * @return bool
     */
    public function bodyIsValidLength(): bool
    {
        return strlen($this->body) === 34;
    }

    /**
     * @return bool
     */
    public function bodyIsValidStart(): bool
    {
        return hexdec(substr($this->body, 0, 8)) !== 0;
    }

    /**
     * @return bool
     */
    protected function bodyIsValidSerial(): bool
    {
        $imei = strval(hex2bin(substr($this->body, 4)));

        if (strlen($imei) !== 15) {
            return false;
        }

        $this->cache['serial'] = $imei;

        return true;
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->cache[__FUNCTION__];
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ['serial' => $this->serial()];
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return "\x01";
    }
}
