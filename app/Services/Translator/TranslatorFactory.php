<?php declare(strict_types=1);

namespace App\Services\Translator;

use App\Exceptions\UnexpectedValueException;
use App\Services\Translator\Provider\ProviderAbstract;

class TranslatorFactory
{
    /**
     * @return \App\Services\Translator\Provider\ProviderAbstract
     */
    public static function get(): ProviderAbstract
    {
        $provider = static::provider();
        $class = static::class($provider);

        return new $class(static::config()['providers'][$provider]);
    }

    /**
     * @return string
     */
    protected static function provider(): string
    {
        if ($provider = static::config()['provider']) {
            return $provider;
        }

        throw new UnexpectedValueException('Translator Provider Not Defined');
    }

    /**
     * @param string $provider
     *
     * @return string
     */
    protected static function class(string $provider): string
    {
        $class = __NAMESPACE__.'\\Provider\\'.$provider.'\\Manager';

        if (class_exists($class)) {
            return $class;
        }

        throw new UnexpectedValueException(sprintf('No Class Available to Provider %s', $provider));
    }

    /**
     * @return array
     */
    protected static function config(): array
    {
        static $cache;

        return $cache ?? config('translator');
    }
}
