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
            'remote_commit' => $this->remoteCommitCommit(),
        ];
    }

    /**
     * @return bool
     */
    protected function available(): bool
    {
        return $this->cache(fn () => is_file($this->config()) && is_file($this->master()));
    }

    /**
     * @return bool
     */
    protected function updated(): bool
    {
        return $this->cache(fn () => $this->available() && ($this->currentCommitSha() === $this->remoteCommitSha()));
    }

    /**
     * @return string
     */
    protected function master(): string
    {
        return $this->cache(fn () => base_path('.git/refs/heads/master'));
    }

    /**
     * @return string
     */
    protected function config(): string
    {
        return $this->cache(fn () => base_path('.git/config'));
    }

    /**
     * @return ?string
     */
    protected function currentCommitSha(): ?string
    {
        if ($this->available() === false) {
            return null;
        }

        return trim(file_get_contents($this->master()));
    }

    /**
     * @return ?string
     */
    protected function remoteCommitSha(): ?string
    {
        if ($this->available() === false) {
            return null;
        }

        return $this->remoteJson()['sha'] ?? null;
    }

    /**
     * @return ?array
     */
    protected function remoteCommitCommit(): ?array
    {
        if ($this->available() === false) {
            return null;
        }

        return $this->remoteJson()['commit'] ?? null;
    }

    /**
     * @return ?array
     */
    protected function remoteCommit(): ?array
    {
        if ($this->available() === false) {
            return null;
        }

        return $this->remoteJson();
    }

    /**
     * @return ?array
     */
    protected function remoteJson(): ?array
    {
        if ($this->available() === false) {
            return null;
        }

        if (empty($url = $this->remoteRepository())) {
            return null;
        }

        return $this->cache(function () use ($url) {
            return json_decode(file_get_contents($url, false, stream_context_create([
                'http' => [
                    'user_agent' => 'Eusonlito-GPS-Tracker',
                ],
            ])), true);
        });
    }

    /**
     * @return ?string
     */
    protected function remoteRepository(): ?string
    {
        if ($this->available() === false) {
            return null;
        }

        return $this->cache(function () {
            preg_match('/github\.com:(.+)\.git$/m', file_get_contents($this->config()), $matches);

            if (empty($matches)) {
                return null;
            }

            return 'https://api.github.com/repos/'.$matches[1].'/commits/master';
        });
    }
}
