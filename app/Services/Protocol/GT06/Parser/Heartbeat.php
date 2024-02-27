<?php declare(strict_types=1);

namespace App\Services\Protocol\GT06\Parser;

use App\Services\Protocol\ParserAbstract;

class Heartbeat extends ParserAbstract
{
    /**
     * @return array
     */
    public function resources(): array
    {
        $this->values = [];

        if ($this->bodyIsValid() === false) {
            return [];
        }

        $this->addIfValid($this->resourceHeartbeat());

        return $this->resources;
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
            .'(13|23)'        //  3 - protocol
            .'/';
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
        return hex2bin($this->values[1].'05'.$this->values[3].'0001D9DC0D0A');
    }
}
