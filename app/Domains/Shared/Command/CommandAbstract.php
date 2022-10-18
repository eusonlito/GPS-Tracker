<?php declare(strict_types=1);

namespace App\Domains\Shared\Command;

use Illuminate\Console\Command;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Domains\Shared\Traits\Factory;
use App\Exceptions\ValidatorException;

abstract class CommandAbstract extends Command
{
    use Factory;

    /**
     * @return self
     */
    public function __construct()
    {
        $this->request = request();

        parent::__construct();
    }

    /**
     * @param mixed $string
     * @param int|string|null $verbosity = false
     *
     * @return void
     */
    final public function info($string, $verbosity = false)
    {
        if (is_string($string) === false) {
            $string = print_r($string, true);
        }

        parent::info('['.date('Y-m-d H:i:s').'] '.$this->className().' '.$string, $verbosity);
    }

    /**
     * @param mixed $string
     * @param int|string|null $verbosity = false
     *
     * @return void
     */
    final public function error($string, $verbosity = false)
    {
        if (is_string($string) === false) {
            $string = print_r($string, true);
        }

        parent::error('['.date('Y-m-d H:i:s').'] '.$this->className().' '.$string, $verbosity);
    }

    /**
     * @return string
     */
    final public function className()
    {
        $namespace = explode('\\', get_class($this));

        return '['.$namespace[2].'] ['.$namespace[4].']';
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    final protected function checkOption(string $key)
    {
        if (is_null($value = $this->option($key))) {
            throw new ValidatorException(sprintf('Option "%s" is required', $key));
        }

        return $value;
    }

    /**
     * @param array $keys
     *
     * @return void
     */
    final protected function checkOptions(array $keys): void
    {
        foreach ($keys as $key) {
            $this->checkOption($key);
        }
    }

    /**
     * @return \Illuminate\Http\Request
     */
    final protected function requestWithOptions(): Request
    {
        return request()->replace($this->options() + $this->arguments());
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable|int|null $user = null
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    final protected function actingAs($user = null): Authenticatable
    {
        $model = config('auth.providers.users.model');

        if (is_null($user)) {
            $user = new $model();
        } elseif (is_numeric($user)) {
            $user = $model::findOrFail($user);
        }

        Auth::login($user);

        return $this->auth = $user;
    }
}
