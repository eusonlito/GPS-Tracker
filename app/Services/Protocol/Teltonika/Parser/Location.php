<?php declare(strict_types=1);

namespace App\Services\Protocol\Teltonika\Parser;

use App\Services\Buffer\Byte as BufferByte;
use App\Services\Protocol\ParserAbstract;
use App\Services\Protocol\Resource\Location as LocationResource;

class Location extends ParserAbstract
{
    /**
     * @var \App\Services\Buffer\Byte
     */
    protected BufferByte $buffer;

    /**
     * @var string
     */
    protected string $codec;

    /**
     * @var int
     */
    protected int $total;

    /**
     * @param \App\Services\Buffer\Byte $buffer
     *
     * @return self
     */
    public function buffer(BufferByte $buffer): self
    {
        $this->buffer = $buffer;

        return $this;
    }

    /**
     * @param string $codec
     *
     * @return self
     */
    public function codec(string $codec): self
    {
        $this->codec = $codec;

        return $this;
    }

    /**
     * @param int $total
     *
     * @return self
     */
    public function total(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return \App\Services\Protocol\Resource\Location
     */
    public function resource(): LocationResource
    {
        $this->trackStart();
        $this->gps();
        $this->attributes();
        $this->trackEnd();

        return $this->resourceLocation();
    }

    /**
     * @return void
     */
    protected function trackStart(): void
    {
        $this->buffer->trackStart();
    }

    /**
     * @return void
     */
    protected function trackEnd(): void
    {
        $this->cache['message'] = $this->buffer->trackEnd();
    }

    /**
     * @return void
     */
    protected function gps(): void
    {
        $this->cache['datetime'] = date('Y-m-d H:i:s', intval($this->buffer->int(8) / 1000));

        $this->buffer->int(1); // priority

        $this->cache['longitude'] = $this->buffer->intSigned(4) / 10000000;
        $this->cache['latitude'] = $this->buffer->intSigned(4) / 10000000;

        $this->buffer->int(2); // altitude

        $this->cache['direction'] = $this->buffer->int(2);
        $this->cache['signal'] = $this->buffer->int(1);
        $this->cache['speed'] = round($this->buffer->int(2), 2);
    }

    /**
     * @return void
     */
    protected function attributes(): void
    {
        $this->buffer->intIf($this->codec, [Codec::CODEC_8_EXT, Codec::CODEC_16]);

        if ($this->codec === Codec::CODEC_16) {
            $this->buffer->int(1);
        }

        $this->buffer->intIf($this->codec, [Codec::CODEC_8_EXT]);

        $this->attributesBytes(1);
        $this->attributesBytes(2);
        $this->attributesBytes(4);

        if (in_array($this->codec, [Codec::CODEC_8, Codec::CODEC_8_EXT, Codec::CODEC_16])) {
            $this->attributesBytes(8);
        }

        if ($this->codec === Codec::CODEC_8_EXT) {
            $this->attributesCodec8Ext();
        }
    }

    /**
     * @param int $bytes
     *
     * @return void
     */
    protected function attributesBytes(int $bytes): void
    {
        $count = $this->buffer->intIf($this->codec, [Codec::CODEC_8_EXT]);

        for ($i = 0; $i < $count; $i++) {
            $this->buffer->intIf($this->codec, [Codec::CODEC_8_EXT, Codec::CODEC_16]);
            $this->buffer->int($bytes);
        }
    }

    /**
     * @return void
     */
    protected function attributesCodec8Ext(): void
    {
        $count = $this->buffer->int(2);

        for ($i = 0; $i < $count; $i++) {
            $this->buffer->int(2);
            $this->buffer->string($this->buffer->int(2));
        }
    }

    /**
     * @return string
     */
    protected function message(): string
    {
        return $this->cache[__FUNCTION__];
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->data['serial'];
    }

    /**
     * @return ?float
     */
    protected function latitude(): ?float
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?float
     */
    protected function longitude(): ?float
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?float
     */
    protected function speed(): ?float
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?int
     */
    protected function signal(): ?int
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?int
     */
    protected function direction(): ?int
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?string
     */
    protected function datetime(): ?string
    {
        return $this->cache[__FUNCTION__] ?? null;
    }

    /**
     * @return ?string
     */
    protected function country(): ?string
    {
        if (isset($this->cache['mcc'], $this->cache['mnc']) === false) {
            return null;
        }

        return $this->cache[__FUNCTION__] ??= helper()->mcc(
            $this->cache['mcc'],
            $this->cache['mnc']
        )?->iso;
    }

    /**
     * @return ?string
     */
    protected function timezone(): ?string
    {
        if (isset($this->cache['latitude'], $this->cache['longitude']) === false) {
            return null;
        }

        return $this->cache[__FUNCTION__] ??= helper()->latitudeLongitudeTimezone(
            $this->latitude(),
            $this->longitude(),
            $this->country()
        );
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return pack('N', $this->total);
    }
}
