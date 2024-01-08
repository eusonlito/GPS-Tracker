<?php declare(strict_types=1);

namespace App\Services\Server;

class Logger
{
    /**
     * @param int $port
     *
     * @return self
     */
    public static function port(int $port): self
    {
        static $cache;

        return $cache[$port] ??= new self($port);
    }

    /**
     * @param int $port
     *
     * @return self
     */
    private function __construct(protected int $port)
    {
    }

    /**
     * @param string $title
     * @param mixed $data = null
     *
     * @return void
     */
    public function info(string $title, mixed $data = null): void
    {
        $this->write(__FUNCTION__, $title, $data);
    }

    /**
     * @param string $title
     * @param mixed $data = null
     *
     * @return void
     */
    public function error(string $title, mixed $data = null): void
    {
        $this->write(__FUNCTION__, $title, $data);
    }

    /**
     * @param string $status
     * @param mixed $title
     * @param mixed $data = null
     *
     * @return void
     */
    protected function write(string $status, mixed $title, mixed $data = null): void
    {
        file_put_contents($this->file(), $this->contents($status, $title, $data), FILE_APPEND | LOCK_EX);
    }

    /**
     * @return string
     */
    protected function file(): string
    {
        $file = storage_path('logs/server/'.date('Y/m/d').'/'.$this->port.'-connection.log');

        clearstatcache(true, $file);

        if (is_file($file) === false) {
            helper()->mkdir($file, true);
        }

        return $file;
    }

    /**
     * @param string $status
     * @param mixed $title
     * @param mixed $data
     *
     * @return string
     */
    protected function contents(string $status, mixed $title, mixed $data): string
    {
        return '['.$this->timestamp().'] ['.strtoupper($status).'] '.$this->toString($title).' '.$this->toString($data)."\n";
    }

    /**
     * @return string
     */
    protected function timestamp(): string
    {
        return date_create()->format('Y-m-d H:i:s.v P');
    }

    /**
     * @param mixed $contents
     *
     * @return string
     */
    protected function toString(mixed $contents): string
    {
        if (is_numeric($contents)) {
            return strval($contents);
        }

        if (is_string($contents)) {
            return trim($contents);
        }

        return json_encode($contents, JSON_INVALID_UTF8_SUBSTITUTE | JSON_UNESCAPED_LINE_TERMINATORS | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
