<?php declare(strict_types=1);

namespace App\Services\Translator\Provider;

use App\Services\Http\Curl\Curl;

abstract class ProviderAbstract
{
    /**
     * @var array
     */
    protected array $config;

    /**
     * @param array $config
     *
     * @return self
     */
    public function __construct(array $config)
    {
        $this->config($config);
    }

    /**
     * @param array $config
     *
     * @return void
     */
    protected function config(array $config): void
    {
        $this->config = $config;
    }

    /**
     * @param string $url
     *
     * @return \App\Services\Http\Curl\Curl
     */
    protected function curl(string $url): Curl
    {
        return Curl::new()
            ->setMethod('POST')
            ->setUrl($url)
            ->setCache(3600)
            ->setCachePost(true);
    }
}
