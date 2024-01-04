<?php declare(strict_types=1);

namespace App\Domains\Core\Test;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Testing\Fakes\MailFake;
use Faker\Factory as FactoryFaker;
use Faker\Generator as GeneratorFaker;
use Tests\TestsAbstract;
use Tests\CreatesApplication;
use App\Domains\Core\Model\ModelAbstract;
use App\Domains\Core\Traits\Factory;
use App\Domains\User\Model\User as UserModel;
use App\Services\Http\Curl\Curl;
use Database\Seeders\Database as DatabaseSeed;

abstract class TestAbstract extends TestsAbstract
{
    use CreatesApplication;
    use Factory;

    /**
     * @var string
     */
    protected string $seeder = DatabaseSeed::class;

    /**
     * @var \Faker\Generator
     */
    protected GeneratorFaker $faker;

    /**
     * @var ?\Illuminate\Contracts\Auth\Authenticatable
     */
    protected ?Authenticatable $auth = null;

    /**
     * @var string
     */
    protected string $action;

    /**
     * @return string
     */
    abstract protected function getModelClass(): string;

    /**
     * @return string
     */
    protected function getUserClass(): string
    {
        return UserModel::class;
    }

    /**
     * @param ?\Illuminate\Contracts\Auth\Authenticatable $user = null
     *
     * @return self
     */
    protected function auth(?Authenticatable $user = null): self
    {
        $this->auth = $user ?: $this->user();

        $this->actingAs($this->auth);

        return $this;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function user(): Authenticatable
    {
        return $this->rowFirst($this->getUserClass());
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function userLast(): Authenticatable
    {
        return $this->rowLast($this->getUserClass());
    }

    /**
     * @param ?string $model = null
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function rowFirst(?string $model = null): ModelAbstract
    {
        $model = $model ?: $this->getModelClass();

        return $model::query()->orderBy('id', 'ASC')->first()
            ?: $this->factoryCreate($model);
    }

    /**
     * @param ?string $model = null
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function rowLast(?string $model = null): ModelAbstract
    {
        $model = $model ?: $this->getModelClass();

        return $model::query()->orderBy('id', 'DESC')->first()
            ?: $this->factoryCreate($model);
    }

    /**
     * @param \App\Domains\Core\Model\ModelAbstract $row
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function rowFresh(ModelAbstract $row): ModelAbstract
    {
        return $row->fresh();
    }

    /**
     * @return \Faker\Generator
     */
    protected function faker(): GeneratorFaker
    {
        return $this->faker ??= FactoryFaker::create('es_ES');
    }

    /**
     * @param ?string $model = null
     * @param array $data = []
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function factoryCreate(?string $model = null, array $data = []): ModelAbstract
    {
        return ($model ?: $this->getModelClass())::factory()->create($data);
    }

    /**
     * @param ?string $model = null
     * @param array $data = []
     *
     * @return \App\Domains\Core\Model\ModelAbstract
     */
    protected function factoryMake(?string $model = null, array $data = []): ModelAbstract
    {
        return ($model ?: $this->getModelClass())::factory()->make($data);
    }

    /**
     * @param ?string $model = null
     * @param array $whitelist = []
     * @param string|bool $action = ''
     *
     * @return array
     */
    protected function factoryWhitelist(?string $model = null, array $whitelist = [], $action = ''): array
    {
        return $this->whitelist($this->factoryMake($model)->toArray(), $whitelist, $action);
    }

    /**
     * @return \Illuminate\Support\Testing\Fakes\MailFake
     */
    protected function mail(): MailFake
    {
        return (new Mail)->fake();
    }

    /**
     * @param array $data
     * @param array $whitelist = []
     * @param string|bool $action = null
     *
     * @return array
     */
    protected function whitelist(array $data, array $whitelist = [], string|bool|null $action = null): array
    {
        if ($whitelist) {
            $values = array_intersect_key($data, array_flip($whitelist));
        } else {
            $values = $data;
        }

        if (in_array('password', $whitelist, true) && isset($data['email'])) {
            $values['password'] = $data['email'];
        }

        if ($action !== false) {
            $values += $this->action($action);
        }

        return $values;
    }

    /**
     * @param ?string $action = null
     *
     * @return array
     */
    protected function action(?string $action = null): array
    {
        return ['_action' => $action ?: $this->action];
    }

    /**
     * @param array $data
     * @param \App\Domains\Core\Model\ModelAbstract $row
     * @param array $exclude = []
     * @param array $only = []
     *
     * @return void
     */
    protected function dataVsRow(array $data, ModelAbstract $row, array $exclude = [], array $only = []): void
    {
        if ($only) {
            $data = helper()->arrayKeysWhitelist($data, $only);
        } else {
            $data = helper()->arrayKeysBlacklist($data, array_merge(['created_at', 'updated_at'], $exclude));
        }

        foreach ($data as $key => $value) {
            if (is_scalar($value) && is_scalar($row->$key)) {
                $this->assertTrue($value == $row->$key, sprintf('[%s] %s != %s', $key, $value, $row->$key));
            } else {
                $this->assertEquals($value, $row->$key);
            }
        }
    }

    /**
     * @return void
     */
    protected function curlFake(string $file): void
    {
        Curl::fake(preg_replace(['/\n\r/', '/\n/'], ["\n", "\n\r"], file_get_contents(base_path($file))));
    }

    /**
     * @return void
     */
    protected function info(): void
    {
        $debug = debug_backtrace(2)[1];
        $prefix = $debug['class'].'::'.$debug['function'].' - ';

        fwrite(STDERR, "\n");

        foreach (func_get_args() as $each) {
            fwrite(STDERR, "\n".$prefix.print_r($each, true));
        }

        fwrite(STDERR, "\n");
    }
}
