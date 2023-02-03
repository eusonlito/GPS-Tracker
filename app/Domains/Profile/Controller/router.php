<?php declare(strict_types=1);

namespace App\Domains\Profile\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::any('/profile', Update::class)->name('profile.update');
    Route::any('/profile/telegram', UpdateTelegram::class)->name('profile.update.telegram');
    Route::get('/profile/user-session', UpdateUserSession::class)->name('profile.update.user-session');
});
