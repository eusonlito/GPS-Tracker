<?php declare(strict_types=1);

namespace App\Domains\Country\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin-mode']], static function () {
    Route::get('/country', Index::class)->name('country.index');
    Route::any('/country/{id}', Update::class)->name('country.update');
    Route::any('/country/{id}/merge', UpdateMerge::class)->name('country.update.merge');
});
