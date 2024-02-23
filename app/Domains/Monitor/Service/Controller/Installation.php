<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Services\Command\Exec;

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

        exec($this->git().' fetch origin '.$this->branch());
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

        return $this->log()[0] ?? null;
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
            $git = Exec::cmdArray('type git 2>/dev/null');

            return $git ? end($git) : null;
        });
    }

    /**
     * @return string
     */
    protected function branch(): string
    {
        return $this->cache(function () {
            return str_replace('refs/heads/', '', Exec::cmd($this->git().' rev-parse --symbolic-full-name --verify --quiet HEAD'));
        });
    }

    /**
     * @return array
     */
    protected function log(): array
    {
        return $this->cache(function () {
            $log = Exec::cmdLines($this->git().' log -10 --date=iso --format="%cd: %s" 2>&1');

            return $log ? array_map($this->logLine(...), $log) : [];
        });
    }

    /**
     * @return array
     */
    protected function logDiff(): array
    {
        return $this->cache(function () {
            $log = Exec::cmdLines($this->git().' log -10 --date=iso --format="%cd: %s" HEAD..origin/'.$this->branch().' 2>&1');

            return $log ? array_map($this->logLine(...), $log) : [];
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
