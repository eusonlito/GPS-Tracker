<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type;

use App\Domains\Alarm\Service\Type\Format\FormatAbstract;
use App\Exceptions\UnexpectedValueException;

class Manager
{
    /**
     * @const
     */
    protected const FORMATS = [
        'fence-in', 'fence-out', 'movement', 'overspeed', 'polygon-in', 'polygon-out', 'vibration',
    ];

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @return array
     */
    public function titles(): array
    {
        return [
            'fence-in' => __('alarm-type-fence-in.title'),
            'fence-out' => __('alarm-type-fence-out.title'),
            'movement' => __('alarm-type-movement.title'),
            'overspeed' => __('alarm-type-overspeed.title'),
            'polygon-in' => __('alarm-type-polygon-in.title'),
            'polygon-out' => __('alarm-type-polygon-out.title'),
            'vibration' => __('alarm-type-vibration.title'),
        ];
    }

    /**
     * @param ?string $code
     *
     * @return ?string
     */
    public function selected(?string $code): ?string
    {
        return in_array($code, static::FORMATS) ? $code : null;
    }

    /**
     * @param string $code
     * @param array $config
     *
     * @return \App\Domains\Alarm\Service\Type\Format\FormatAbstract
     */
    public function factory(string $code, array $config): FormatAbstract
    {
        return $this->init($this->class($code), $config);
    }

    /**
     * @param string $code
     *
     * @return string
     */
    protected function class(string $code): string
    {
        return match ($code) {
            'fence-in' => $this->classFormat('FenceIn'),
            'fence-out' => $this->classFormat('FenceOut'),
            'movement' => $this->classFormat('Movement'),
            'overspeed' => $this->classFormat('Overspeed'),
            'polygon-in' => $this->classFormat('PolygonIn'),
            'polygon-out' => $this->classFormat('PolygonOut'),
            'vibration' => $this->classFormat('Vibration'),
            default => throw new UnexpectedValueException(__('alarm-type.error.invalid')),
        };
    }

    /**
     * @param string $class
     *
     * @return string
     */
    protected function classFormat(string $class): string
    {
        return __NAMESPACE__.'\\Format\\'.$class;
    }

    /**
     * @param string $class
     * @param array $config
     *
     * @return \App\Domains\Alarm\Service\Type\Format\FormatAbstract
     */
    protected function init(string $class, array $config): FormatAbstract
    {
        return new $class($config);
    }
}
