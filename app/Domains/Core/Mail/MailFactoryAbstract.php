<?php declare(strict_types=1);

namespace App\Domains\Core\Mail;

use BadMethodCallException;
use ReflectionClass;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

abstract class MailFactoryAbstract
{
    /**
     * @var ?\Illuminate\Contracts\Auth\Authenticatable
     */
    protected ?Authenticatable $auth;

    /**
     * @param ?\Illuminate\Contracts\Auth\Authenticatable $auth = null
     *
     * @return self
     */
    final public function __construct(?Authenticatable $auth = null)
    {
        $this->auth = $auth;
    }

    /**
     * @param \Illuminate\Mail\Mailable $mail
     *
     * @return \Illuminate\Mail\Mailable
     */
    final public function send(Mailable $mail): Mailable
    {
        return tap($mail, static fn () => Mail::send($mail));
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return \Illuminate\Mail\Mailable
     */
    final public function __call(string $name, array $arguments): Mailable
    {
        $class = (new ReflectionClass($this))->getNamespaceName().'\\'.ucfirst($name);

        if (class_exists($class) === false) {
            throw new BadMethodCallException();
        }

        return $this->send($this->new($class, $arguments));
    }

    /**
     * @param string $class
     * @param array $arguments
     *
     * @return \App\Domains\Core\Mail\MailAbstract
     */
    final protected function new(string $class, array $arguments): MailAbstract
    {
        return new $class(...$arguments);
    }
}
