<?php declare(strict_types=1);

namespace App\Services\Protocol\Teltonika\Parser;

use App\Services\Protocol\ParserAbstract;

class Auth extends ParserAbstract
{
    /**
     * @var int
     */
    protected int $length;

    /**
     * @return array
     */
    public function resources(): array
    {
        $this->decode();
        $this->length();

        if ($this->bodyIsValid() === false) {
            return [];
        }

        $this->addIfValid($this->resourceAuth());

        return $this->resources;
    }

    /**
     * @return void
     */
    protected function decode(): void
    {
        $this->body = hex2bin($this->body);
    }

    /**
     * @return void
     */
    protected function length(): void
    {
        $this->length = unpack('n', substr($this->body, 0, 2))[1];
    }

    /**
     * @return bool
     */
    public function bodyIsValid(): bool
    {
        return $this->bodyIsValidLength()
            && $this->bodyIsValidSerial();
    }

    /**
     * @return bool
     */
    public function bodyIsValidLength(): bool
    {
        return $this->length === (strlen($this->body) - 2);
    }

    /**
     * @return bool
     */
    protected function bodyIsValidSerial(): bool
    {
        $imei = substr($this->body, 2, $this->length);

        if (strlen($imei) !== $this->length) {
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
