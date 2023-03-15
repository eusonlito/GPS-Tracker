<?php declare(strict_types=1);

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as KernelVendor;
use App\Domains\Configuration\Middleware\Request as ConfigurationRequest;
use App\Domains\IpLock\Middleware\Check as IpLockCheck;
use App\Domains\Language\Middleware\Request as LanguageRequest;
use App\Domains\User\Middleware\Admin as UserAdmin;
use App\Domains\User\Middleware\AuthRedirect as UserAuthRedirect;
use App\Domains\User\Middleware\Enabled as UserEnabled;
use App\Domains\User\Middleware\Request as UserRequest;
use App\Domains\Vehicle\Middleware\Available as VehicleAvailable;
use App\Http\Middleware\Https;
use App\Http\Middleware\MessagesShareFromSession;
use App\Http\Middleware\RequestLogger;
use App\Http\Middleware\Reset;
use App\Http\Middleware\TrustProxies;

class Kernel extends KernelVendor
{
    /**
     * @var array<int, string>
     */
    protected $middleware = [
        TrustProxies::class,
        Https::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        RequestLogger::class,
        Reset::class,
        MessagesShareFromSession::class,
        ConfigurationRequest::class,
        LanguageRequest::class,
    ];

    /**
     * @var array<string, array<int, string>>
     */
    protected $middlewareGroups = [
        'user-auth' => [
            IpLockCheck::class,
            UserRequest::class,
            UserEnabled::class,
        ],

        'user-auth-admin' => [
            UserRequest::class,
            UserEnabled::class,
            UserAdmin::class,
        ],
    ];

    /**
     * @var array<string, string>
     */
    protected $middlewareAliases = [
        'vehicle.available' => VehicleAvailable::class,
        'user.admin' => UserAdmin::class,
        'user.auth.redirect' => UserAuthRedirect::class,
        'user.enabled' => UserEnabled::class,
        'user.request' => UserRequest::class,
    ];
}
