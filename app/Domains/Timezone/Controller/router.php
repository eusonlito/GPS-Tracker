<?php declare(strict_types=1);

namespace App\Domains\Timezone\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin-mode']], static function () {
    Route::get('/timezone', Index::class)->name('timezone.index');
    Route::any('/timezone/{id}/default', UpdateDefault::class)->name('timezone.update.default');
});
