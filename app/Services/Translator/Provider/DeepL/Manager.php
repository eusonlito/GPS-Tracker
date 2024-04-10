<?php declare(strict_types=1);

namespace App\Services\Translator\Provider\DeepL;

use stdClass;
use Throwable;
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
        try {
            return $this->requestResponse($this->requestCurl($from, $to, $strings));
        } catch (Throwable $e) {
            return $this->requestError($e);
        }
    }

    /**
     * @param \Throwable $e
     *
     * @return array
     */
    protected function requestError(Throwable $e): array
    {
        report($e);

        return [];
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
        return $this->requestBodyTextTags(implode("\n", $this->requestBodyTextKeys($strings)));
    }

    /**
     * @param array $strings
     *
     * @return array
     */
    protected function requestBodyTextKeys(array $strings): array
    {
        return array_map(
            static fn ($value, $key) => '<key>'.$key.'</key> '.$value,
            $strings,
            array_keys($strings)
        );
    }

    /**
     * @param string $text
     *
     * @return string
     */
    protected function requestBodyTextTags(string $text): string
    {
        return preg_replace_callback('/:[a-z_]+/', static function (array $tag) {
            return '[BASE64:'.base64_encode($tag[0]).']';
        }, $text);
    }

    /**
     * @param \stdClass $response
     *
     * @return array
     */
    protected function requestResponse(stdClass $response): array
    {
        $text = $response->translations[0]->text;

        $text = $this->requestResponseTags($text);
        $keys = $this->requestResponseKeys($text);
        $strings = $this->requestResponseString($text);

        $translations = [];

        foreach ($keys as $index => $key) {
            if (empty($strings[$index])) {
                exit(var_export([$text, $keys, $strings], true));
            }

            $translations[$key] = $strings[$index];
        }

        return $translations;
    }

    /**
     * @param string $text
     *
     * @return string
     */
    protected function requestResponseTags(string $text): string
    {
        return preg_replace_callback('/\[BASE64:([^\]]+)\]/', static function (array $tag) {
            return base64_decode($tag[1]);
        }, $text);
    }

    /**
     * @param string $text
     *
     * @return array
     */
    protected function requestResponseKeys(string $text): array
    {
        preg_match_all('/<key>([^<]+)<\/key>/', $text, $matches);

        return $matches[1];
    }

    /**
     * @param string $text
     *
     * @return array
     */
    protected function requestResponseString(string $text): array
    {
        return array_map('trim', explode("\n", preg_replace('/<key>([^<]*)<\/key>/', '', $text)));
    }
}
