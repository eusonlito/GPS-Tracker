<?php declare(strict_types=1);

namespace App\Domains\City\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin-mode']], static function () {
    Route::get('/city', Index::class)->name('city.index');
    Route::any('/city/{id}', Update::class)->name('city.update');
    Route::any('/city/{id}/merge', UpdateMerge::class)->name('city.update.merge');
});
