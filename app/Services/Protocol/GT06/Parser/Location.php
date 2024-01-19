<?php declare(strict_types=1);

namespace App\Services\Protocol\GT06\Parser;

use App\Services\Buffer\Bit as BufferBit;
use App\Services\Buffer\Byte as BufferByte;
use App\Services\Protocol\ParserAbstract;

class Location extends ParserAbstract
{
    /**
     * @return array
     */
    public function resources(): array
    {
        if ($this->bodyIsValid() === false) {
            return [];
        }

        $this->modules();

        $this->addIfValid($this->resourceLocation());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function bodyIsValid(): bool
    {
        return ($this->data['serial'] ?? false)
            && (bool)preg_match($this->bodyIsValidRegExp(), $this->body);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/^'
            .'(7979)'        //  1 - start
            .'([0-9a-f]{4})' //  2 - length
            .'(70)'          //  3 - protocol
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
     * @return void
     */
    protected function modules(): void
    {
        $buffer = new BufferByte(substr($this->body, 10, -8));

        while ($buffer->length() > 6) {
            $type = $buffer->string(2);
            $content = $buffer->new($buffer->int(2));

            match ($type) {
                '0011' => $this->moduleCellTower($content),
                '0033' => $this->moduleGps($content),
                '002C' => $this->moduleTimestamp($content),
                default => null,
            };
        }
    }

    /**
     * @param \App\Services\Buffer\Byte $buffer
     *
     * @return void
     */
    protected function moduleGps(BufferByte $buffer): void
    {
        $this->cache['datetime'] = date('Y-m-d H:i:s', $buffer->int(4));

        $this->cache['latitude'] = round($buffer->int(4, 7) / 60 / 30000, 5);
        $this->cache['longitude'] = round($buffer->int(4) / 60 / 30000, 5);

        $this->cache['speed'] = round($buffer->int(1) * 1.852, 2);

        $flags = $buffer->int();

        $this->cache['direction'] = BufferBit::to($flags, 10);
        $this->cache['signal'] = intval(BufferBit::check($flags, 12));

        if (BufferBit::check($flags, 10) === false) {
            $this->cache['latitude'] = -$this->cache['latitude'];
        }

        if (BufferBit::check($flags, 11)) {
            $this->cache['longitude'] = -$this->cache['longitude'];
        }
    }

    /**
     * @param \App\Services\Buffer\Byte $buffer
     *
     * @return void
     */
    protected function moduleCellTower(BufferByte $buffer): void
    {
        $this->cache['mcc'] = $buffer->int(2);
        $this->cache['mnc'] = $buffer->int(2);
    }

    /**
     * @param \App\Services\Buffer\Byte $buffer
     *
     * @return void
     */
    protected function moduleTimestamp(BufferByte $buffer): void
    {
        $this->cache['datetime'] = date('Y-m-d H:i:s', $buffer->int());
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

        return $this->cache[__FUNCTION__] ??= helper()->mcc($this->cache['mcc'], $this->cache['mnc'])?->iso;
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
        return '';
    }
}
