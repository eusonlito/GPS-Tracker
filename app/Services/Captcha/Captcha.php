<?php declare(strict_types=1);

namespace App\Services\Captcha;

use Eusonlito\Captcha\Captcha as CaptchaVendor;
use App\Domains\UserFail\Model\UserFail as UserFailModel;

class Captcha
{
    /**
     * @const array
     */
    protected const LETTERS = [5, 7];

    /**
     * @const array
     */
    protected const DOTS = [8, 15];

    /**
     * @const array
     */
    protected const LINES = [5, 8];

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @return self
     */
    public function __construct()
    {
        CaptchaVendor::setNoise(static::DOTS, static::LINES);
    }

    /**
     * @return bool
     */
    public function requiredAuth(): bool
    {
        return $this->requiredAuthIpDay();
    }

    /**
     * @return bool
     */
    public function requiredAuthIpDay(): bool
    {
        return UserFailModel::query()
            ->byIp(request()->ip())
            ->byCreatedAtAfter(date('Y-m-d H:i:s', strtotime('-1 day')))
            ->count() >= 2;
    }

    /**
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function source(int $width, int $height): string
    {
        $image = CaptchaVendor::source(static::LETTERS, $width, $height);

        session(['captcha' => strtolower(CaptchaVendor::string())]);

        return $image;
    }

    /**
     * @return ?string
     */
    public function sessionValue(): ?string
    {
        return session('captcha');
    }
}
