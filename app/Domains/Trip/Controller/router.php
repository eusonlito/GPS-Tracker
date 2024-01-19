<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth', 'vehicle.available']], static function () {
    Route::get('/trip', Index::class)->name('trip.index');
    Route::any('/trip/import', Import::class)->name('trip.import');
    Route::any('/trip/heatmap', Heatmap::class)->name('trip.heatmap');
    Route::any('/trip/map', Map::class)->name('trip.map');
    Route::any('/trip/search', Search::class)->name('trip.search');
    Route::any('/trip/{id}', Update::class)->name('trip.update');
    Route::any('/trip/{id}/alarm-notification', UpdateAlarmNotification::class)->name('trip.update.alarm-notification');
    Route::any('/trip/{id}/boolean/{column}', UpdateBoolean::class)->name('trip.update.boolean');
    Route::any('/trip/{id}/export', UpdateExport::class)->name('trip.update.export');
    Route::any('/trip/{id}/map', UpdateMap::class)->name('trip.update.map');
    Route::any('/trip/{id}/merge', UpdateMerge::class)->name('trip.update.merge');
    Route::any('/trip/{id}/position', UpdatePosition::class)->name('trip.update.position');
    Route::any('/trip/{id}/stat', UpdateStat::class)->name('trip.update.stat');
});
