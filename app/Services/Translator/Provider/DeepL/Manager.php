<?php declare(strict_types=1);

namespace App\Services\Translator\Provider\DeepL;

use stdClass;
use App\Exceptions\UnexpectedValueException;
use App\Services\Translator\Provider\ProviderAbstract;

class Manager extends ProviderAbstract
{
    /**
     * @const string
     */
    protected const ENDPOINT = 'https://api-free.deepl.com/v2/translate';

    /**
     * @param array $config
     *
     * @return void
     */
    protected function config(array $config): void
    {
        if (empty($config['key'])) {
            throw new UnexpectedValueException('You must set a DeepL Key');
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
        return $this->request($from, $to, $strings);
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
        return $this->requestResponse($this->requestCurl($from, $to, $strings));
    }

    /**
     * @param string $from
     * @param string $to
     * @param array $strings
     *
     * @return \stdClass
     */
    protected function requestCurl(string $from, string $to, array $strings): stdClass
    {
        return $this->curl($this->requestEndpoint())
            ->setMethod('post')
            ->setHeaders($this->requestHeaders())
            ->setBody($this->requestBody($from, $to, $strings))
            ->setLog(true)
            ->send()
            ->getBody('object');
    }

    /**
     * @return string
     */
    protected function requestEndpoint(): string
    {
        return static::ENDPOINT;
    }

    /**
     * @return array
     */
    protected function requestHeaders(): array
    {
        return [
            'Authorization' => 'DeepL-Auth-Key '.$this->config['key'],
        ];
    }

    /**
     * @param string $from
     * @param string $to
     * @param array $strings
     *
     * @return array
     */
    protected function requestBody(string $from, string $to, array $strings): array
    {
        return [
            'source_lang' => strtoupper($from),
            'target_lang' => strtoupper($to),
            'text' => $this->requestBodyText($strings),
            'split_sentences' => 1,
            'preserve_formatting' => 1,
            'formality' => 'prefer_less',
            'tag_handling' => 'xml',
            'ignore_tags' => 'key',
        ];
    }

    /**
     * @param array $strings
     *
     * @return string
     */
    protected function requestBodyText(array $strings): string
    {
        return implode("\n", array_map(static fn ($value, $key) => '<key>'.$key.'</key> '.$value, $strings, array_keys($strings)));
    }

    /**
     * @param \stdClass $response
     *
     * @return array
     */
    protected function requestResponse(stdClass $response): array
    {
        $translations = [];

        foreach (explode("\n", $response->translations[0]->text) as $line) {
            preg_match('/^<key>([^<]+)<\/key> (.*)$/', $line, $matches);

            $translations[$matches[1]] = $matches[2];
        }

        return $translations;
    }
}
