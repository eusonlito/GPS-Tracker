<?php declare(strict_types=1);

namespace App\Domains\IpLock\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin-mode']], static function () {
    Route::get('/ip-lock', Index::class)->name('ip-lock.index');
    Route::any('/ip-lock/create', Create::class)->name('ip-lock.create');
    Route::any('/ip-lock/{id}', Update::class)->name('ip-lock.update');
    Route::any('/ip-lock/{id}/end-at', UpdateEndAt::class)->name('ip-lock.update.end-at');
});
