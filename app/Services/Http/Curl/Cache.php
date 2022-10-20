<?php declare(strict_types=1);

namespace App\Services\Http\Curl;

class Cache
{
    /**
     * @var int
     */
    protected int $ttl = 0;

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

        $this->keyGenerate($data);

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
     * @param array $data
     *
     * @return self
     */
    protected function keyGenerate(array $data): self
    {
        $this->key = md5(json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR));

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
     * @return ?array
     */
    public function get(): ?array
    {
        return $this->exists() ? json_decode(file_get_contents($this->file()), true) : null;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function set(array $data): void
    {
        $file = $this->file();

        file_put_contents($file, helper()->jsonEncode($data), LOCK_EX);

        touch($file, time() + $this->ttl);
    }

    /**
     * @return string
     */
    public function file(): string
    {
        return $this->path.'/'.$this->key.'.json';
    }
}
