<?php declare(strict_types=1);

namespace App\Services\Http\Curl;

use Closure;
use CurlFile;
use CurlHandle;
use Throwable;

class Curl
{
    /**
     * @var ?string
     */
    protected static ?string $fake = null;

    /**
     * @var \CurlHandle
     */
    protected CurlHandle $curl;

    /**
     * @var int
     */
    protected int $timeout = 30;

    /**
     * @var string
     */
    protected string $url = '';

    /**
     * @var string
     */
    protected string $urlRequest = '';

    /**
     * @var string
     */
    protected string $method = 'GET';

    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * @var array
     */
    protected array $query = [];

    /**
     * @var bool
     */
    protected bool $cachePost = false;

    /**
     * @var \App\Services\Http\Curl\Cache
     */
    protected Cache $cache;

    /**
     * @var mixed
     */
    protected mixed $body;

    /**
     * @var array
     */
    protected array $bodyFiles = [];

    /**
     * @var mixed
     */
    protected mixed $bodyRequest;

    /**
     * @var int
     */
    protected int $sleep = 0;

    /**
     * @var bool
     */
    protected bool $isJson = false;

    /**
     * @var bool
     */
    protected bool $isJsonResponse = false;

    /**
     * @var bool
     */
    protected bool $isMultipart = false;

    /**
     * @var string
     */
    protected string $boundary;

    /**
     * @var bool
     */
    protected bool $exception = true;

    /**
     * @var bool
     */
    protected bool $errorReport = true;

    /**
     * @var bool
     */
    protected bool $log = false;

    /**
     * @var bool
     */
    protected bool $logContents = true;

    /**
     * @var bool
     */
    protected bool $logBody = true;

    /**
     * @var ?\Closure
     */
    protected ?Closure $sendSuccess = null;

    /**
     * @var int
     */
    protected int $retry = 0;

    /**
     * @var int
     */
    protected int $retryWait = 1000;

    /**
     * @var ?int
     */
    protected ?int $retryCount = null;

    /**
     * @var ?string
     */
    protected ?string $response = '';

    /**
     * @var array
     */
    protected array $responseHeaders = [];

    /**
     * @var array
     */
    protected array $info = [];

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param ?string $fake = null
     *
     * @return void
     */
    public static function fake(?string $fake = null): void
    {
        static::$fake = $fake;
    }

    /**
     * @return self
     */
    public function __construct()
    {
        $this->initCurl();
        $this->initCache();
    }

    /**
     * @return self
     */
    protected function initCurl(): self
    {
        $this->curl = curl_init();

        $this->setOption(CURLOPT_COOKIESESSION, false);
        $this->setOption(CURLOPT_FOLLOWLOCATION, true);
        $this->setOption(CURLOPT_FORBID_REUSE, true);
        $this->setOption(CURLOPT_FRESH_CONNECT, true);
        $this->setOption(CURLOPT_HEADER, true);
        $this->setOption(CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $this->setOption(CURLOPT_MAXREDIRS, 5);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $this->setOption(CURLOPT_SSL_VERIFYHOST, false);
        $this->setOption(CURLOPT_TIMEOUT, $this->timeout);

        $this->setHeader('User-Agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.96 Safari/537.36');
        $this->setHeader('Connection', 'close');

        return $this;
    }

    /**
     * @return self
     */
    protected function initCache(): self
    {
        $this->cache = new Cache();

        return $this;
    }

    /**
     * @param int $option
     * @param mixed $value
     *
     * @return self
     */
    public function setOption(int $option, $value): self
    {
        curl_setopt($this->curl, $option, $value);

        return $this;
    }

    /**
     * @param string $method
     *
     * @return self
     */
    public function setMethod(string $method): self
    {
        $this->method = strtoupper($method);

        $this->setOption(CURLOPT_CUSTOMREQUEST, $this->method);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param array $query
     *
     * @return self
     */
    public function setQuery(array $query): self
    {
        $this->query = array_merge($this->query, $query);

        return $this;
    }

    /**
     * @param mixed $body
     *
     * @return self
     */
    public function setBody(mixed $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param bool $body
     *
     * @return self
     */
    public function setNoBody(bool $body): self
    {
        $this->setOption(CURLOPT_NOBODY, $body);

        return $this;
    }

    /**
     * @param string $name
     * @param string $file
     * @param ?string $mime = null
     *
     * @return self
     */
    public function setBodyFile(string $name, string $file, ?string $mime = null): self
    {
        $this->bodyFiles[] = [
            'name' => $name,
            'file' => $file,
            'mime' => (($mime === null) ? mime_content_type($file) : $mime),
        ];

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return self
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return self
     */
    public function setHeader(string $key, $value): self
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * @param callable $function
     *
     * @return self
     */
    public function setHeaderFunction(callable $function): self
    {
        $this->setOption(CURLOPT_HEADERFUNCTION, $function);

        return $this;
    }

    /**
     * @param string $file
     *
     * @return self
     */
    public function setCookieFile(string $file): self
    {
        $this->setOption(CURLOPT_COOKIESESSION, true);
        $this->setOption(CURLOPT_COOKIEFILE, $file);
        $this->setOption(CURLOPT_COOKIEJAR, $file);

        return $this;
    }

    /**
     * @param ?string $token
     * @param bool $bearer = true
     *
     * @return self
     */
    public function setAuthorization(?string $token, bool $bearer = true): self
    {
        if ($token) {
            $this->setHeader('Authorization', ($bearer ? 'Bearer ' : '').$token);
        }

        return $this;
    }

    /**
     * @param string $user
     * @param string $password
     *
     * @return self
     */
    public function setUserPassword(string $user, string $password): self
    {
        $this->setOption(CURLOPT_USERPWD, $user.':'.$password);

        return $this;
    }

    /**
     * @param bool $json = true
     *
     * @return self
     */
    public function setJson(bool $json = true): self
    {
        $this->isJson = $json;

        if ($this->isJson) {
            $this->setHeader('Content-Type', 'application/json');
        }

        $this->setJsonResponse($json);

        return $this;
    }

    /**
     * @param bool $jsonResponse = true
     *
     * @return self
     */
    public function setJsonResponse(bool $jsonResponse = true): self
    {
        $this->isJsonResponse = $jsonResponse;

        if ($this->isJsonResponse) {
            $this->setHeader('Accept', 'application/json');
        }

        return $this;
    }

    /**
     * @param bool $multipart = true
     *
     * @return self
     */
    public function setMultipart(bool $multipart = true): self
    {
        $this->isMultipart = $multipart;
        $this->boundary = md5(uniqid());

        $this->setHeader('Content-Type', 'multipart/form-data; boundary='.$this->boundary);

        return $this;
    }

    /**
     * @param int $timeout
     *
     * @return self
     */
    public function setTimeOut(int $timeout): self
    {
        $this->setOption(CURLOPT_TIMEOUT, $this->timeout = $timeout);

        return $this;
    }

    /**
     * @return self
     */
    public function setStream(): self
    {
        $this->setHeader('Content-Type', 'application/octet-stream');

        $this->setOption(CURLOPT_WRITEFUNCTION, [$this, 'setStreamWriteFunction']);

        return $this;
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param \CurlHandle $curl
     * @param string $string
     *
     * @return int
     */
    protected function setStreamWriteFunction(CurlHandle $curl, string $string): int
    {
        echo $string;

        return strlen($string);
    }

    /**
     * @param resource $fp
     * @param ?int $size = null
     *
     * @return self
     */
    public function setFile($fp, ?int $size = null): self
    {
        $this->setOption(CURLOPT_UPLOAD, true);
        $this->setOption(CURLOPT_INFILE, $fp);
        $this->setOption(CURLOPT_BINARYTRANSFER, true);

        if ($size !== null) {
            $this->setOption(CURLOPT_INFILESIZE, $size);
        }

        return $this;
    }

    /**
     * @param int $sleep
     *
     * @return self
     */
    public function setSleep(int $sleep): self
    {
        $this->sleep = $sleep;

        return $this;
    }

    /**
     * @param bool $exception = true
     *
     * @return self
     */
    public function setException(bool $exception = true): self
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * @param bool $errorReport = true
     *
     * @return self
     */
    public function setErrorReport(bool $errorReport = true): self
    {
        $this->errorReport = $errorReport;

        return $this;
    }

    /**
     * @param int $ttl
     *
     * @return self
     */
    public function setCache(int $ttl): self
    {
        $this->cache->setTTL($ttl);

        return $this;
    }

    /**
     * @param bool $cache = true
     *
     * @return self
     */
    public function setCachePost(bool $cache = true): self
    {
        $this->cachePost = $cache;

        return $this;
    }

    /**
     * @param bool $log = true
     *
     * @return self
     */
    public function setLog(bool $log = true): self
    {
        $this->log = $log;

        return $this;
    }

    /**
     * @param bool $logContents = true
     *
     * @return self
     */
    public function setLogContents(bool $logContents = true): self
    {
        $this->logContents = $logContents;

        return $this;
    }

    /**
     * @param bool $logBody = true
     *
     * @return self
     */
    public function setLogBody(bool $logBody = true): self
    {
        $this->logBody = $logBody;

        return $this;
    }

    /**
     * @param ?callable $sendSuccess
     *
     * @return self
     */
    public function setSendSuccess(?callable $sendSuccess): self
    {
        $this->sendSuccess = $sendSuccess;

        return $this;
    }

    /**
     * @param int $ttl
     * @param int $wait = 1000
     *
     * @return self
     */
    public function setRetry(int $ttl, int $wait = 1000): self
    {
        $this->retry = $ttl;
        $this->retryWait = ($wait > 10) ? $wait : ($wait * 1000);

        return $this;
    }

    /**
     * @return self
     */
    public function writeHeaders(): self
    {
        $this->headers = array_filter($this->headers);

        if (empty($this->headers)) {
            return $this;
        }

        $this->setOption(CURLOPT_HTTPHEADER, array_map(static function (string $key, $value): string {
            return $key.': '.(is_array($value) ? json_encode($value) : $value);
        }, array_keys($this->headers), $this->headers));

        return $this;
    }

    /**
     * @return self
     */
    public function send(): self
    {
        $this->cacheSetData();

        if ($this->cacheGet() === false) {
            $this->sendExec();
        }

        if ($this->sendSuccess()) {
            $this->success();
        } else {
            $this->error();
        }

        curl_close($this->curl);

        return $this;
    }

    /**
     * @return self
     */
    protected function sendExec(): self
    {
        if ($this->sleep) {
            sleep($this->sleep);
        }

        $this->writeHeaders();

        $this->sendUrl();
        $this->sendPost();

        if ($response = static::$fake) {
            $this->info = [];
        } else {
            $response = curl_exec($this->curl);
            $this->info = curl_getinfo($this->curl);
        }

        $this->responseHeaders = [];

        if (is_string($response) === false) {
            return $this;
        }

        [$headers, $this->response] = explode("\r\n\r\n", $response, 2) + ['', null];

        $this->responseHeaders($headers);

        return $this;
    }

    /**
     * @param string $headers
     *
     * @return void
     */
    protected function responseHeaders(string $headers): void
    {
        $this->responseHeaders = [];

        $headers = explode("\n", $headers);

        array_shift($headers);

        foreach ($headers as $header) {
            if (preg_match('#^([^:]+):\s*(.+)$#', $header, $matches)) {
                $this->responseHeaders[strtolower($matches[1])] = trim($matches[2]);
            }
        }
    }

    /**
     * @return bool
     */
    public function sendSuccess(): bool
    {
        if ($this->sendSuccessCheck() === false) {
            return false;
        }

        if (empty($this->info)) {
            return true;
        }

        return in_array($this->info['http_code'], [200, 201, 204, 304]);
    }

    /**
     * @return bool
     */
    public function sendSuccessCheck(): bool
    {
        if ($this->sendSuccess === null) {
            return true;
        }

        return call_user_func($this->sendSuccess, $this->getBody());
    }

    /**
     * @param ?string $format = null
     *
     * @return mixed
     */
    public function getBody(?string $format = null): mixed
    {
        if (empty($this->response)) {
            return null;
        }

        if ($this->isJsonResponse && ($format === null)) {
            $format = 'object';
        }

        return match ($format) {
            'array' => json_decode($this->response, true),
            'object' => json_decode($this->response),
            default => $this->response,
        };
    }

    /**
     * @param string $key = ''
     *
     * @return mixed
     */
    public function getHeaders(string $key = ''): mixed
    {
        return $key ? ($this->responseHeaders[$key] ?? null) : $this->responseHeaders;
    }

    /**
     * @param string $key = ''
     *
     * @return mixed
     */
    public function getInfo(string $key = ''): mixed
    {
        return $key ? ($this->info[$key] ?? null) : $this->info;
    }

    /**
     * @return self
     */
    protected function sendUrl(): self
    {
        $this->setOption(CURLOPT_URL, $this->sendUrlString());

        return $this;
    }

    /**
     * @return string
     */
    protected function sendUrlString(): string
    {
        return $this->urlRequest = $this->urlWithQuery($this->url, $this->query);
    }

    /**
     * @param string $url
     * @param array $query
     *
     * @return string
     */
    protected function urlWithQuery(string $url, array $query): string
    {
        if ($query) {
            $url .= (str_contains($url, '?') ? '&' : '?').http_build_query($query, '', '&');
        }

        return $url;
    }

    /**
     * @return self
     */
    protected function sendPost(): self
    {
        if (in_array($this->method, ['POST', 'PUT']) === false) {
            return $this;
        }

        if (empty($this->body)) {
            return $this;
        }

        return match (gettype($this->body)) {
            'string' => $this->sendPostString(),
            'boolean' => $this->sendPostBoolean(),
            default => $this->sendPostArray(),
        };
    }

    /**
     * @return self
     */
    protected function sendPostString(): self
    {
        return $this->setOption(CURLOPT_POSTFIELDS, $this->body);
    }

    /**
     * @return self
     */
    protected function sendPostArray(): self
    {
        if ($this->bodyFiles) {
            $this->bodyRequest = $this->sendPostArrayFiles();
        } elseif ($this->isJson) {
            $this->bodyRequest = $this->sendPostArrayJson();
        } elseif ($this->isMultipart) {
            $this->bodyRequest = $this->sendPostArrayMultipart();
        } else {
            $this->bodyRequest = $this->sendPostArrayString();
        }

        return $this->setOption(CURLOPT_POSTFIELDS, $this->bodyRequest);
    }

    /**
     * @return array
     */
    protected function sendPostArrayFiles(): array
    {
        $files = [];

        foreach ($this->bodyFiles as $file) {
            $files[$file['name']] = new CurlFile($file['file'], $file['mime']);
        }

        return $files + $this->body;
    }

    /**
     * @return string
     */
    protected function sendPostArrayJson(): string
    {
        return json_encode($this->body);
    }

    /**
     * @return string
     */
    protected function sendPostArrayMultipart(): string
    {
        $body = '';

        foreach ($this->body as $name => $value) {
            $body .= $this->sendPostArrayMultipartInput($name, $value);
        }

        return $body;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return string
     */
    protected function sendPostArrayMultipartInput(string $name, mixed $value): string
    {
        $header = '--'.$this->boundary."\r\n"
            .'Content-Disposition: form-data; name="'.$name.'"'."\r\n";

        if (is_array($value) || is_object($value)) {
            $header .= 'Content-Type: application/json;charset=utf-8'."\r\n";
            $value = json_encode($value);
        } elseif (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        } else {
            $value = strval($value);
        }

        return $header."\r\n".$value."\r\n".'--'.$this->boundary.'--'."\r\n";
    }

    /**
     * @return string
     */
    protected function sendPostArrayString(): string
    {
        return http_build_query($this->body, '', '&');
    }

    /**
     * @return self
     */
    protected function sendPostBoolean(): self
    {
        return $this;
    }

    /**
     * @return bool
     */
    protected function cacheEnabled(): bool
    {
        return (($this->method === 'GET') || $this->cachePost)
            && $this->cache->getEnabled();
    }

    /**
     * @return void
     */
    protected function cacheSetData(): void
    {
        if ($this->cacheEnabled()) {
            $this->cache->setData($this->getVars());
        }
    }

    /**
     * @return bool
     */
    protected function cacheGet(): bool
    {
        if ($this->cacheGetEnabled() === false) {
            return false;
        }

        $cached = $this->cache->get();

        $this->response = $cached['response'] ?? null;
        $this->responseHeaders = $cached['responseHeaders'] ?? null;
        $this->info = $cached['info'] ?? null;

        return true;
    }

    /**
     * @return bool
     */
    protected function cacheGetEnabled(): bool
    {
        return $this->cacheEnabled()
            && $this->cache->exists();
    }

    /**
     * @return void
     */
    protected function cacheSet(): void
    {
        if ($this->cacheSetEnabled()) {
            $this->cache->set($this->getVars());
        }
    }

    /**
     * @return bool
     */
    protected function cacheSetEnabled(): bool
    {
        return $this->cacheEnabled()
            && is_string($this->response)
            && ($this->cache->exists() === false);
    }

    /**
     * @return void
     */
    protected function success(): void
    {
        $this->logSet();
        $this->cacheSet();
    }

    /**
     * @return void
     */
    protected function error(): void
    {
        $this->logSet('error', $e = $this->exception());

        if ($this->errorReport && app()->bound('sentry')) {
            app('sentry')->captureException($e);
        }

        $this->retry($e);
    }

    /**
     * @param \App\Services\Http\Curl\CurlException $e
     *
     * @return void
     */
    protected function retry(CurlException $e): void
    {
        if (is_int($this->retryCount)) {
            return;
        }

        $success = false;

        for ($this->retryCount = 0; $this->retryCount < $this->retry; $this->retryCount++) {
            if ($success = $this->retryExec()) {
                break;
            }

            usleep($this->retryWait * 1000);
        }

        $this->retryCount = null;

        if (($success === false) && $this->exception) {
            throw $e;
        }
    }

    /**
     * @return bool
     */
    protected function retryExec(): bool
    {
        $this->sendExec();

        if ($success = $this->sendSuccess()) {
            $this->success();
        } else {
            $this->error();
        }

        return $success;
    }

    /**
     * @return array
     */
    protected function getVars(): array
    {
        $vars = get_object_vars($this);

        unset($vars['curl']);

        return $vars;
    }

    /**
     * @return \App\Services\Http\Curl\CurlException
     */
    protected function exception(): CurlException
    {
        $message = $this->exceptionMessage(strval($this->response));
        $code = $this->exceptionCode(strval($this->response), $this->info['http_code']);

        return new CurlException(substr($message, 0, 1024), $code);
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function exceptionMessage(string $message): string
    {
        if (str_starts_with($message, '{') === false) {
            return $message;
        }

        if (empty($json = json_decode($message, true))) {
            return $message;
        }

        return $json['message']
            ?? $json['error']['message']
            ?? $json['error']
            ?? $json['msg']
            ?? $message;
    }

    /**
     * @param string $message
     * @param int $code
     *
     * @return int
     */
    protected function exceptionCode(string $message, int $code): int
    {
        if ($code !== 400) {
            return $code;
        }

        if ($this->isAuthException($message)) {
            return 401;
        }

        return $code;
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    protected function isAuthException(string $message): bool
    {
        return str_contains($message, 'invalid_grant')
            || str_contains($message, 'invalid_request')
            || str_contains($message, 'unsupported_grant_type')
            || str_contains($message, 'unauthorized_client');
    }

    /**
     * @param string $status = 'success'
     * @param ?\Throwable $e = null
     *
     * @return void
     */
    protected function logSet(string $status = 'success', ?Throwable $e = null): void
    {
        $this->logFile($status);

        if ($e) {
            report($e);
        }
    }

    /**
     * @param string $status
     *
     * @return void
     */
    protected function logFile(string $status): void
    {
        if ($this->log !== true) {
            return;
        }

        $data = $this->getVars();

        if ($this->logBody === false) {
            $data['body'] = 'NO-LOG-BODY';
        }

        if ($this->logContents === false) {
            $data['response'] = 'NO-LOG-CONTENTS';
        } elseif ($this->isJsonResponse && $data['response']) {
            $data['response'] = json_decode($data['response']);
        }

        Log::write($this->url, $status, $data);
    }
}
