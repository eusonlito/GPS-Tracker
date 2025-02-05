<?php declare(strict_types=1);

namespace App\Services\Protocol\H02\Parser;

use App\Services\Buffer\Byte as BufferByte;
use App\Services\Protocol\ParserAbstract;

class LocationBinary extends ParserAbstract
{
    /**
     * @var \App\Services\Buffer\Byte
     */
    protected BufferByte $buffer;

    /**
     * @return array
     */
    public function resources(): array
    {
        if ($this->messageIsValid() === false) {
            return [];
        }

        $this->setBuffer();
        $this->setSerial();
        $this->setDate();
        $this->setLatitude();
        $this->setBattery();
        $this->setLongitude();
        $this->setFlags();
        $this->setSpeedDirection();
        $this->setStatus();
        $this->setMccMnc();

        $this->addIfValid($this->resourceLocation());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function messageIsValid(): bool
    {
        return $this->messageIsValidLength()
            && $this->messageIsValidStart();
    }

    /**
     * @return bool
     */
    protected function messageIsValidLength(): bool
    {
        return (strlen($this->message) === 84)
            || (strlen($this->message) === 90);
    }

    /**
     * @return bool
     */
    protected function messageIsValidStart(): bool
    {
        return str_starts_with($this->message, '24');
    }

    /**
     * @return void
     */
    protected function setBuffer(): void
    {
        $this->buffer = new BufferByte($this->message);
    }

    /**
     * @return void
     */
    protected function setSerial(): void
    {
        $this->buffer->index(1);
        $this->cache['serial'] = $this->buffer->string(5);
    }

    /**
     * @return void
     */
    protected function setDate(): void
    {
        $hour = $this->buffer->string(1);
        $minute = $this->buffer->string(1);
        $second = $this->buffer->string(1);
        $day = $this->buffer->string(1);
        $month = $this->buffer->string(1);
        $year = $this->buffer->string(1);

        $this->cache['datetime'] = sprintf(
            '20%s-%s-%s %s:%s:%s',
            $year,
            $month,
            $day,
            $hour,
            $minute,
            $second,
        );
    }

    /**
     * @return void
     */
    protected function setLatitude(): void
    {
        preg_match('/(.{2})(.{2})(.{4})/', $this->buffer->string(4), $matches);

        $this->cache['latitude'] = intval($matches[1]) + (floatval($matches[2].'.'.$matches[3]) / 60);
    }

    /**
     * @return void
     */
    protected function setBattery(): void
    {
        $this->buffer->string(1);
    }

    /**
     * @return void
     */
    protected function setLongitude(): void
    {
        preg_match('/(.{3})(.{2})(.{4})/', $this->buffer->string(5), $matches);

        $this->cache['longitude'] = intval($matches[1]) + (floatval($matches[2].'.'.$matches[3]) / 60);
    }

    /**
     * @return void
     */
    protected function setFlags(): void
    {
        $flags = $this->buffer->peek(-1);

        $this->cache['signal'] = (($flags & 0x02) !== 0) ? 1 : 0;

        if (($flags & 0x04) === 0) {
            $this->cache['latitude'] *= -1;
        }

        if (($flags & 0x08) === 0) {
            $this->cache['longitude'] *= -1;
        }
    }

    /**
     * @return void
     */
    protected function setSpeedDirection(): void
    {
        $value = $this->buffer->string(3);

        $this->cache['speed'] = intval(substr($value, 0, 3));
        $this->cache['direction'] = intval(substr($value, 3, 3));
    }

    /**
     * @return void
     */
    protected function setStatus(): void
    {
        // Vehicle Status
        $this->buffer->string(4);
        // Alarm Flag
        $this->buffer->string(1);
        // Mileage
        $this->buffer->string(4);
    }

    /**
     * @return void
     */
    protected function setMccMnc(): void
    {
        $this->cache['mcc'] = $this->buffer->int(2);
        $this->cache['mnc'] = $this->buffer->int(1);
    }

    /**
     * @return string
     */
    protected function message(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    protected function maker(): string
    {
        return 'HQ';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->cache[__FUNCTION__];
    }

    /**
     * @return ?string
     */
    protected function type(): ?string
    {
        return 'V5';
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
        return '*'.$this->maker().','.$this->serial().',V4,'.$this->type().','.date('YmdHis').'#';
    }
}
