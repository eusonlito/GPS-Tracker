<?php declare(strict_types=1);

namespace App\Services\Protocol\Teltonika\Parser;

use App\Services\Buffer\Byte as BufferByte;
use App\Services\Protocol\ParserAbstract;

class Locations extends ParserAbstract
{
    /**
     * @return array
     */
    public function resources(): array
    {
        if ($this->bodyIsValid() === false) {
            return [];
        }

        $this->read();

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function bodyIsValid(): bool
    {
        return $this->bodyIsValidStart()
            && $this->bodyIsValidSerial();
    }

    /**
     * @return bool
     */
    public function bodyIsValidStart(): bool
    {
        return hexdec(substr($this->body, 0, 8)) === 0;
    }

    /**
     * @return bool
     */
    protected function bodyIsValidSerial(): bool
    {
        return empty($this->data['serial']) === false;
    }

    /**
     * @return void
     */
    protected function read(): void
    {
        $this->readCrc();

        $length = hexdec(substr($this->body, 8, 8));
        $buffer = new BufferByte(substr($this->body, 16, $length * 2));

        if ($buffer->int(1) !== 8) {
            return;
        }

        $count = $buffer->int(1);

        for ($i = 0; $i < $count; $i++) {
            $this->readResource($buffer);
        }
    }

    /**
     * @return void
     */
    protected function readCrc(): void
    {
        $this->cache['crc'] = substr($this->body, -8);
    }

    /**
     * @param \App\Services\Buffer\Byte $buffer
     *
     * @return void
     */
    protected function readResource(BufferByte $buffer): void
    {
        $this->addIfValid(Location::new('', $this->readResourceData())->buffer($buffer)->resource());
    }

    /**
     * @return array
     */
    protected function readResourceData(): array
    {
        return $this->data + [
            'crc' => $this->cache['crc'],
        ];
    }
}
