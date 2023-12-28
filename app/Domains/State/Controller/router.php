<?php declare(strict_types=1);

namespace App\Domains\State\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin-mode']], static function () {
    Route::get('/state', Index::class)->name('state.index');
    Route::any('/state/{id}', Update::class)->name('state.update');
    Route::any('/state/{id}/merge', UpdateMerge::class)->name('state.update.merge');
});
