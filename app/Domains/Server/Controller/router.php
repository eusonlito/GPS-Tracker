<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin']], static function () {
    Route::any('/server/log', Log::class)->name('server.log');
});
