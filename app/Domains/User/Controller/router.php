<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'user.auth.redirect'], static function () {
    Route::any('/user/auth', AuthCredentials::class)->name('user.auth.credentials');
});

Route::group(['middleware' => ['user.request']], static function () {
    Route::get('/user/logout', Logout::class)->name('user.logout');
});

Route::group(['middleware' => ['user-auth']], static function () {
    Route::any('/user/profile', Profile::class)->name('user.profile');
    Route::any('/user/profile/telegram', ProfileTelegram::class)->name('user.profile.telegram');
    Route::any('/user/profile/user-session', ProfileUserSession::class)->name('user.profile.user-session');
    Route::any('/user/disabled', Disabled::class)->name('user.disabled');
});

Route::group(['middleware' => ['user-auth-admin']], static function () {
    Route::get('/user', Index::class)->name('user.index');
    Route::any('/user/create', Create::class)->name('user.create');
    Route::any('/user/{id}', Update::class)->name('user.update');
});
