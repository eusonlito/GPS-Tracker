<?php declare(strict_types=1);

namespace App\Domains\Shared\Test;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Testing\Fakes\MailFake;
use Faker\Factory as FactoryFaker;
use Faker\Generator as GeneratorFaker;
use App\Domains\Shared\Model\ModelAbstract;
use App\Domains\Shared\Traits\Factory;
use App\Domains\User\Model\User as UserModel;
use Database\Seeders\Database as DatabaseSeed;
use Tests\TestsAbstract;
use Tests\CreatesApplication;

abstract class TestAbstract extends TestsAbstract
{
    use CreatesApplication;
    use Factory;

    /**
     * @var string
     */
    protected $seeder = DatabaseSeed::class;

    /**
     * @var \Faker\Generator
     */
    protected GeneratorFaker $faker;

    /**
     * @var ?\Illuminate\Contracts\Auth\Authenticatable
     */
    protected ?Authenticatable $auth = null;

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user = null
     *
     * @return self
     */
    protected function auth(Authenticatable $user = null): self
    {
        $this->auth = $user ?: $this->user();

        $this->actingAs($this->auth);

        return $this;
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    protected function user(): UserModel
    {
        return UserModel::orderBy('id', 'ASC')->first() ?: $this->factoryCreate(UserModel::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    protected function userLast(): UserModel
    {
        return UserModel::orderBy('id', 'DESC')->first() ?: $this->factoryCreate(UserModel::class);
    }

    /**
     * @param string $class
     *
     * @return \App\Domains\Shared\Model\ModelAbstract
     */
    protected function rowLast(string $class): ModelAbstract
    {
        return $class::orderBy('id', 'DESC')->first() ?: $class::factory()->create();
    }

    /**
     * @return \Faker\Generator
     */
    protected function faker(): GeneratorFaker
    {
        return $this->faker ??= FactoryFaker::create('es_ES');
    }

    /**
     * @param string $class
     *
     * @return \App\Domains\Shared\Model\ModelAbstract
     */
    protected function factoryCreate(string $class): ModelAbstract
    {
        return $class::factory()->create();
    }

    /**
     * @param string $class
     *
     * @return \App\Domains\Shared\Model\ModelAbstract
     */
    protected function factoryMake(string $class): ModelAbstract
    {
        return $class::factory()->make();
    }

    /**
     * @param string $class
     * @param array $whitelist = []
     * @param string|bool $action = ''
     *
     * @return array
     */
    protected function factoryWhitelist(string $class, array $whitelist = [], $action = ''): array
    {
        return $this->whitelist($this->factoryMake($class)->toArray(), $whitelist, $action);
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
     * @param string|bool $action = ''
     *
     * @return array
     */
    protected function whitelist(array $data, array $whitelist = [], $action = ''): array
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
