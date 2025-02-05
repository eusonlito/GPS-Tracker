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
        if ($this->messageIsValid() === false) {
            return [];
        }

        $this->addIfValid($this->resourceAuth());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function messageIsValid(): bool
    {
        return $this->messageIsValidLength()
            && $this->messageIsValidSerial();
    }

    /**
     * @return bool
     */
    public function messageIsValidLength(): bool
    {
        return strlen($this->message) === 34;
    }

    /**
     * @return bool
     */
    protected function messageIsValidSerial(): bool
    {
        $length = hexdec(substr($this->message, 0, 4));
        $imei = hex2bin(substr($this->message, 4, $length * 2));

        if (strlen($imei) !== $length) {
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
