<?php declare(strict_types=1);

namespace App\Services\Translator\Provider\Microsoft;

use App\Exceptions\UnexpectedValueException;
use App\Services\Translator\Provider\ProviderAbstract;

class Manager extends ProviderAbstract
{
    /**
     * @const string
     */
    protected const ENDPOINT = 'https://api.cognitive.microsofttranslator.com/translate?api-version=3.0&from=:from&to=:to';

    /**
     * @param array $config
     *
     * @return void
     */
    protected function config(array $config): void
    {
        if (empty($config['key']) || empty($config['region'])) {
            throw new UnexpectedValueException('You must set a Microsoft Azure Key and Region');
        }

        $this->config = $config;
    }

    /**
     * @param string $from
     * @param string $to
     * @param array $strings
     *
     * @return array
     */
    public function array(string $from, string $to, array $strings): array
    {
        return $this->response($this->request($from, $to, $strings));
    }

    /**
     * @param string $from
     * @param string $to
     * @param array $strings
     *
     * @return array
     */
    protected function request(string $from, string $to, array $strings): array
    {
        return $this->curl($this->requestEndpoint($from, $to))
            ->setHeaders($this->requestHeaders())
            ->setBody($this->requestBody($strings))
            ->send()
            ->getBody('object');
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    protected function requestEndpoint(string $from, string $to): string
    {
        return str_replace([':from', ':to'], [$from, $to], static::ENDPOINT);
    }

    /**
     * @return array
     */
    protected function requestHeaders(): array
    {
        return [
            'Content-type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $this->config['key'],
            'Ocp-Apim-Subscription-Region' => $this->config['region'],
        ];
    }

    /**
     * @param array $strings
     *
     * @return string
     */
    protected function requestBody(array $strings): string
    {
        return json_encode(array_map(static fn ($value) => ['Text' => $value], array_values($strings)));
    }

    /**
     * @param array $response
     *
     * @return array
     */
    protected function response(array $response): array
    {
        return array_map(static fn ($value) => $value->translations[0]->text, $response);
    }
}
