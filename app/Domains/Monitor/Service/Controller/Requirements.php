<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Services\Command\Exec;

class Requirements extends ControllerAbstract
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
            'functions' => $this->functions(),
            'commands' => $this->commands(),
            'phpinfo' => $this->phpinfo(),
        ];
    }

    /**
     * @return array
     */
    protected function functions(): array
    {
        $list = [];

        foreach ($this->functionsList() as $function) {
            $list[$function] = function_exists($function);
        }

        return $list;
    }

    /**
     * @return array
     */
    protected function functionsList(): array
    {
        return [
            'exec',
            'fsockopen',
            'pcntl_signal',
            'shell_exec',
            'stream_socket_server',
        ];
    }

    /**
     * @return array
     */
    protected function commands(): array
    {
        $list = ['php' => Exec::php()];

        foreach ($this->commandsList() as $command) {
            $list[$command] = Exec::available($command);
        }

        return $list;
    }

    /**
     * @return array
     */
    protected function commandsList(): array
    {
        return [
            'df',
            'free',
            'fuser',
            'git',
            'nohup',
            'nproc',
            'ps',
            'top',
        ];
    }

    /**
     * @return string
     */
    protected function phpinfo(): string
    {
        ob_start();

        phpinfo(INFO_ALL & ~INFO_ENVIRONMENT & ~INFO_VARIABLES);

        return base64_encode(ob_get_clean());
    }
}
