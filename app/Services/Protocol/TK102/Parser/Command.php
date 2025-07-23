<?php declare(strict_types=1);

namespace App\Services\Protocol\TK102\Parser;

use App\Services\Protocol\ParserAbstract;

class Command extends ParserAbstract
{
    /**
     * @return array
     */
    public function resources(): array
    {
        if ($this->messageIsValid() === false) {
            return [];
        }

        $this->addIfValid($this->resourceCommand());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function messageIsValid(): bool
    {
        foreach ($this->validResponses() as $response) {
            if (str_starts_with($this->message, $response)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    protected function validResponses(): array
    {
        return [
            'begin', 'password', 'admin', 'noadmin',
            'notn', 'monitor', 'tracker', 'stockade', 'nostockage',
            'move', 'nomove', 'speed', 'nospeed', 'help',
        ];
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
    protected function type(): string
    {
        foreach ($this->validResponses() as $response) {
            if (str_starts_with($this->message, $response)) {
                return $response;
            }
        }

        return '';
    }

    /**
     * @return array
     */
    protected function payload(): array
    {
        return [$this->message];
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return '';
    }
}
