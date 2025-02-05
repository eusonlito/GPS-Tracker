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
        if ($this->messageIsValid() === false) {
            return [];
        }

        $this->read();

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function messageIsValid(): bool
    {
        return $this->messageIsValidStart()
            && $this->messageIsValidSerial();
    }

    /**
     * @return bool
     */
    public function messageIsValidStart(): bool
    {
        return hexdec(substr($this->message, 0, 8)) === 0;
    }

    /**
     * @return bool
     */
    protected function messageIsValidSerial(): bool
    {
        return empty($this->data['serial']) === false;
    }

    /**
     * @return void
     */
    protected function read(): void
    {
        $length = hexdec(substr($this->message, 8, 8));
        $buffer = new BufferByte(substr($this->message, 16, $length * 2));

        $codec = $buffer->string(1);

        if ($this->isValidCodec($codec) === false) {
            return;
        }

        $count = $buffer->int(1);

        for ($i = 0; $i < $count; $i++) {
            $this->readResource($buffer, $codec, $count);
        }
    }

    /**
     * @return bool
     */
    protected function isValidCodec(string $codec): bool
    {
        return in_array($codec, [Codec::CODEC_8, Codec::CODEC_8_EXT, Codec::CODEC_16]);
    }

    /**
     * @param \App\Services\Buffer\Byte $buffer
     * @param string $codec
     * @param int $count
     *
     * @return void
     */
    protected function readResource(BufferByte $buffer, string $codec, int $count): void
    {
        $this->addIfValid(
            Location::new('', $this->data)
                ->buffer($buffer)
                ->codec($codec)
                ->total($count)
                ->resource()
        );
    }
}
