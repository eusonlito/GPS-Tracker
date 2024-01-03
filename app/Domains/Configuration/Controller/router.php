<?php declare(strict_types=1);

namespace App\Domains\Configuration\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin-mode']], static function () {
    Route::get('/configuration', Index::class)->name('configuration.index');
    Route::any('/configuration/{id}', Update::class)->name('configuration.update');
});
