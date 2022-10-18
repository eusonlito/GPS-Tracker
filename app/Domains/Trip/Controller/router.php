<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth', 'device.available']], static function () {
    Route::get('/trip', Index::class)->name('trip.index');
    Route::any('/trip/{id}', Update::class)->name('trip.update');
    Route::any('/trip/{id}/export', Export::class)->name('trip.export');
    Route::any('/trip/{id}/map', UpdateMap::class)->name('trip.update.map');
    Route::any('/trip/{id}/merge', UpdateMerge::class)->name('trip.update.merge');
    Route::any('/trip/{id}/position', UpdatePosition::class)->name('trip.update.position');
});
