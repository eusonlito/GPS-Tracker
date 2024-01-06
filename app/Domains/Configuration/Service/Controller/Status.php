<?php declare(strict_types=1);

namespace App\Domains\Configuration\Service\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class Status extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'available' => $this->available(),
            'updated' => $this->updated(),
            'current' => $this->current(),
            'log' => $this->log(),
            'commits' => $this->commits(),
            'more' => $this->more(),
        ];
    }

    /**
     * @return bool
     */
    protected function available(): bool
    {
        return $this->cache(fn () => $this->git() && is_dir(base_path('.git')));
    }

    /**
     * @return bool
     */
    protected function updated(): bool
    {
        return empty($this->log());
    }

    /**
     * @return ?string
     */
    protected function git(): ?string
    {
        return $this->cache(function () {
            return str_contains($git = trim(shell_exec('which git')), 'not found') ? null : $git;
        });
    }

    /**
     * @return string
     */
    protected function branch(): string
    {
        return $this->cache(fn () => trim(shell_exec($this->git().' branch --show-current')));
    }

    /**
     * @return array
     */
    protected function log(): array
    {
        return $this->cache(function () {
            exec($this->git().' log --date=iso-strict --format="%cd: %s" HEAD..origin/'.$this->branch(), $output);

            return array_map($this->logLine(...), $output);
        });
    }

    /**
     * @param string $line
     *
     * @return array
     */
    protected function logLine(string $line): array
    {
        $line = explode(': ', $line, 2);

        return [
            'date' => $line[0],
            'message' => $line[1],
        ];
    }

    /**
     * @return ?array
     */
    protected function current(): ?array
    {
        if ($this->available() === false) {
            return null;
        }

        return $this->logLine(trim(shell_exec($this->git().' log -1 --date=iso-strict --format="%cd: %s"')));
    }

    /**
     * @return ?array
     */
    protected function commits(): ?array
    {
        if ($this->available() === false) {
            return null;
        }

        return array_slice($this->log(), 0, 5);
    }

    /**
     * @return ?int
     */
    protected function more(): ?int
    {
        if ($this->available() === false) {
            return null;
        }

        return count($this->log()) - 5;
    }
}
