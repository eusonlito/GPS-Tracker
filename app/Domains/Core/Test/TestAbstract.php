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
     * @param ?int $id = null
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function user(?int $id = null): Authenticatable
    {
        $model = $this->getUserClass();

        if ($id) {
            return $model::query()->findOrFail($id);
        }

        return $model::query()->orderBy('id', 'ASC')->first()
            ?: $this->factoryCreate($model);
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function userLast(): Authenticatable
    {
        $model = $this->getUserClass();

        return $model::query()->orderBy('id', 'DESC')->first()
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
            ?: $model::factory()->create();
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
