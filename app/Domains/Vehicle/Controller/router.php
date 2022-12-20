<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/vehicle', Index::class)->name('vehicle.index');
    Route::any('/vehicle/create', Create::class)->name('vehicle.create');
    Route::any('/vehicle/{id}', Update::class)->name('vehicle.update');
    Route::any('/vehicle/{id}/alarm', UpdateAlarm::class)->name('vehicle.update.alarm');
    Route::any('/vehicle/{id}/alarm-notification', UpdateAlarmNotification::class)->name('vehicle.update.alarm-notification');
});
