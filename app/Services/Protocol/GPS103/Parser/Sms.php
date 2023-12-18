<?php declare(strict_types=1);

namespace App\Services\Protocol\GPS103\Parser;

use App\Services\Protocol\Resource\Sms as SmsResource;

class Sms extends ParserAbstract
{
    /**
     * @return ?\App\Services\Protocol\Resource\Sms
     */
    public function resource(): ?SmsResource
    {
        if ($this->bodyIsValid() === false) {
            return null;
        }

        $this->values = explode(',', substr($this->body, 1, -1));

        return new SmsResource([
            'body' => $this->body,
            'serial' => $this->serial(),
            'type' => $this->type(),
            'payload' => $this->payload(),
            'response' => $this->response(),
        ]);
    }

    /**
     * @return bool
     */
    public function bodyIsValid(): bool
    {
        return (bool)preg_match($this->bodyIsValidRegExp(), $this->body);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/^WIP$/';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return explode(':', $this->values[0])[1];
    }

    /**
     * @return string
     */
    protected function type(): string
    {
        return $this->values[1];
    }

    /**
     * @return array
     */
    protected function payload(): array
    {
        return $this->cache[__FUNCTION__] ??= array_slice($this->values, 2);
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return '';
    }
}
