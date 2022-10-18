<?php declare(strict_types=1);

namespace App\Services\Http\Curl;

class Cache
{
    /**
     * @var int
     */
    protected int $ttl = 0;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var string
     */
    protected string $key = '';

    /**
     * @var string
     */
    protected string $path;

    /**
     * @return self
     */
    public function __construct()
    {
        $this->setup();
    }

    /**
     * @return self
     */
    protected function setup(): self
    {
        $this->path = storage_path('cache/curl');

        helper()->mkdir($this->path);

        return $this;
    }

    /**
     * @param int $ttl
     *
     * @return self
     */
    public function setTTL(int $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data): self
    {
        unset($data['ttl'], $data['sleep']);

        $this->data = $data;
        $this->keyGenerate();

        return $this;
    }

    /**
     * @return bool
     */
    public function getEnabled(): bool
    {
        return (bool)$this->ttl;
    }

    /**
     * @return self
     */
    protected function keyGenerate(): self
    {
        $this->key = md5(json_encode($this->data, JSON_PARTIAL_OUTPUT_ON_ERROR));

        return $this;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return is_file($file = $this->file())
            && (filemtime($file) > time());
    }

    /**
     * @return ?string
     */
    public function get(): ?string
    {
        return $this->exists() ? file_get_contents($this->file()) : null;
    }

    /**
     * @param string $contents
     *
     * @return string
     */
    public function set(string $contents): string
    {
        $file = $this->file();

        file_put_contents($file, $contents, LOCK_EX);

        touch($file, time() + $this->ttl);

        $this->info();

        return $contents;
    }

    /**
     * @return void
     */
    public function info(): void
    {
        $file = $this->file().'.json';

        file_put_contents($file, json_encode(
            $this->data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_LINE_TERMINATORS | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE |
            JSON_INVALID_UTF8_IGNORE | JSON_INVALID_UTF8_SUBSTITUTE | JSON_PARTIAL_OUTPUT_ON_ERROR
        ), LOCK_EX);
    }

    /**
     * @return string
     */
    public function file(): string
    {
        return $this->path.'/'.$this->key;
    }
}
