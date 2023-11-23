<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Type\Format;

class FenceOut extends FormatAbstract
{
    /**
     * @return string
     */
    public function code(): string
    {
        return 'fence-out';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return __('alarm-type-fence-out.title');
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('alarm-type-fence-out.message');
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        $config = $this->config();

        if (empty($config['latitude'])) {
            $this->exceptionValidator(__('alarm-type-fence-out.error.latitude'));
        }

        if (empty($config['longitude'])) {
            $this->exceptionValidator(__('alarm-type-fence-out.error.longitude'));
        }

        if (empty($config['radius'])) {
            $this->exceptionValidator(__('alarm-type-fence-out.error.radius'));
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
