<?php declare(strict_types=1);

namespace App\Services\Protocol\GPS103\Parser;

use App\Services\Protocol\Resource\Heartbeat as HeartbeatResource;

class Heartbeat extends ParserAbstract
{
    /**
     * @return ?\App\Services\Protocol\Resource\Heartbeat
     */
    public function resource(): ?HeartbeatResource
    {
        if ($this->bodyIsValid() === false) {
            return null;
        }

        $this->values = explode(',', $this->body);

        return new HeartbeatResource([
            'body' => $this->body,
            'serial' => $this->serial(),
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
        return '/^'
            .'[0-9]+' // 0 - serial
            .'$/';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->values[0];
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return 'ON';
    }
}
