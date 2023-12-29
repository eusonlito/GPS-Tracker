<?php declare(strict_types=1);

namespace App\Services\Protocol\GT06\Parser;

use App\Services\Protocol\Resource\Heartbeat as HeartbeatResource;

class Heartbeat extends ParserAbstract
{
    /**
     * @return ?\App\Services\Protocol\Resource\Heartbeat
     */
    public function resource(): ?HeartbeatResource
    {
        $this->values = [];

        if ($this->bodyIsValid() === false) {
            return null;
        }

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
        return ($this->data['serial'] ?? false)
            && (bool)preg_match($this->bodyIsValidRegExp(), $this->body, $this->values);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/^'
            .'(7878)'         //  1 - start
            .'([0-9a-f]{2})'  //  2 - length
            .'(23)'           //  3 - protocol
            .'([0-9a-f]{12})' //  4 - information
            .'([0-9a-f]{4})'  //  5 - serial number
            .'([0-9a-f]{4})'  //  6 - error check
            .'$/';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->data['serial'];
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return "\x78\x78\x05\x23\x01\x00\x67\x0E\x0D\x0A";
    }
}
