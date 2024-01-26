<?php declare(strict_types=1);

namespace App\Domains\Core\Command;

use ReflectionClass;
use Illuminate\Console\Command;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\Core\Model\ModelAbstract;
use App\Domains\Core\Traits\Factory;
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
    final public function info($string, $verbosity = null): void
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
    final public function error($string, $verbosity = null): void
    {
        if (is_string($string) === false) {
            $string = print_r($string, true);
        }

        parent::error('['.date('Y-m-d H:i:s').'] '.$this->className().' '.$string, $verbosity);
    }

    /**
     * @return string
     */
    final public function className(): string
    {
        $namespace = explode('\\', get_class($this));

        return '['.$namespace[2].'] ['.$namespace[4].']';
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    final protected function checkOption(string $key): mixed
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
     * @param string $key
     *
     * @return \Illuminate\Http\Request
     */
    final protected function requestOptionAsFile(string $key): Request
    {
        $value = $this->option($key);

        if (empty($value)) {
            return request();
        }

        if (str_starts_with($value, '/') === false) {
            $value = base_path($value);
        }

        if (is_file($value) === false) {
            throw new ValidatorException(sprintf('The "%s" "%s" does not exists', $key, $value));
        }

        $file = new UploadedFile($value, basename($value), mime_content_type($value), UPLOAD_ERR_OK, true);

        return request()->merge([$key => $file]);
    }

    /**
     * @return \Illuminate\Http\Request
     */
    final protected function requestMergeRow(): Request
    {
        return request()->replace(array_filter(request()->input()) + $this->row->toArray());
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable|int|null $user = null
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    final protected function actingAs(Authenticatable|int|null $user = null): Authenticatable
    {
        $model = config('auth.providers.users.model');

        if (is_null($user)) {
            $user = new $model();
        } elseif (is_int($user)) {
            $user = $model::query()->findOrFail($user);
        }

        $this->factory($this->actingAsDomain($user), $user)->action()->set();

        return $this->auth = $user;
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return string
     */
    final protected function actingAsDomain(Authenticatable $user): string
    {
        return (new ReflectionClass($user))->getShortName();
    }

    /**
     * @param ?\App\Domains\Core\Model\ModelAbstract $row = null
     * @param array $data = []
     *
     * @return \App\Domains\Core\Action\ActionFactoryAbstract
     */
    final protected function action(?ModelAbstract $row = null, array $data = []): ActionFactoryAbstract
    {
        return $this->factory(row: $row)->action($data);
    }
}
