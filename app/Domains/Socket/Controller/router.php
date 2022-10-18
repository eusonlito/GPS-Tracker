<?php declare(strict_types=1);

namespace App\Domains\Socket\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin']], static function () {
    Route::any('/socket', Index::class)->name('socket.index');
});
