<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class Installation extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->fetch();
    }

    /**
     * @return void
     */
    protected function fetch(): void
    {
        if ($this->available() === false) {
            return;
        }

        shell_exec($this->git().' fetch origin '.$this->branch());
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
            'updated_commits' => $this->updatedCommits(),
            'pending_commits' => $this->pendingCommits(),
            'pending_commits_count' => $this->pendingCommitsCount(),
            'pending_more' => $this->pendingMore(),
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
        if ($this->available() === false) {
            return false;
        }

        return $this->cache(fn () => empty($this->logDiff()));
    }

    /**
     * @return ?array
     */
    protected function current(): ?array
    {
        if ($this->available() === false) {
            return null;
        }

        return $this->log()[0];
    }

    /**
     * @return ?array
     */
    protected function updatedCommits(): ?array
    {
        if ($this->available() === false) {
            return null;
        }

        return array_slice($this->log(), 1, 6);
    }

    /**
     * @return ?array
     */
    protected function pendingCommits(): ?array
    {
        if ($this->available() === false) {
            return null;
        }

        return array_slice($this->logDiff(), 0, 5);
    }

    /**
     * @return ?int
     */
    protected function pendingCommitsCount(): ?int
    {
        if ($this->available() === false) {
            return null;
        }

        return count($this->logDiff());
    }

    /**
     * @return ?int
     */
    protected function pendingMore(): ?int
    {
        if ($this->available() === false) {
            return null;
        }

        return max(0, count($this->logDiff()) - 5);
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
            exec($this->git().' log -10 --date=iso-strict --format="%cd: %s"', $output);

            return array_map($this->logLine(...), $output);
        });
    }

    /**
     * @return array
     */
    protected function logDiff(): array
    {
        return $this->cache(function () {
            exec($this->git().' log -10 --date=iso-strict --format="%cd: %s" HEAD..origin/'.$this->branch(), $output);

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
            'date' => helper()->dateFormattedToTimezone($line[0], $this->auth->timezone->zone),
            'message' => $line[1],
        ];
    }
}
