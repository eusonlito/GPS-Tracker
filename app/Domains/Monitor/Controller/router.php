<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin-mode']], static function () {
    Route::get('/monitor/installation', Installation::class)->name('monitor.installation');
});
