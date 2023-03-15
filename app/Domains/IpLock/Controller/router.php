<?php declare(strict_types=1);

namespace App\Domains\IpLock\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin']], static function () {
    Route::any('/ip-lock/{id}/end-at', UpdateEndAt::class)->name('ip-lock.update.end-at');
});
