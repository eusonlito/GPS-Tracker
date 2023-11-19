<?php declare(strict_types=1);

namespace App\Domains\UserSession\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin-mode']], static function () {
    Route::get('/user-session', Index::class)->name('user-session.index');
});
