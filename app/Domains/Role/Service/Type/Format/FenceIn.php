<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

class FenceIn extends FormatAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'fence-in';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('alarm-type-fence-in.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('alarm-type-fence-in.message');
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        $config = $this->config();

        if (empty($config['latitude'])) {
            $this->exceptionValidator(__('alarm-type-fence-in.error.latitude'));
        }

        if (empty($config['longitude'])) {
            $this->exceptionValidator(__('alarm-type-fence-in.error.longitude'));
        }

        if (empty($config['radius'])) {
            $this->exceptionValidator(__('alarm-type-fence-in.error.radius'));
        }
    }

    /**
     * @return array
     */
    public function config(): array
    {
        return [
            'latitude' => floatval($this->config['latitude'] ?? 0),
            'longitude' => floatval($this->config['longitude'] ?? 0),
            'radius' => floatval($this->config['radius'] ?? 0),
        ];
    }
}
