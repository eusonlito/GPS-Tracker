<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarmNotification\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/device-alarm-notification', Index::class)->name('device-alarm-notification.index');
    Route::any('/device-alarm-notification/{id}/closed-at', UpdateClosedAt::class)->name('device-alarm-notification.update.closed-at');
    Route::any('/device-alarm-notification/{id}/sent-at', UpdateSentAt::class)->name('device-alarm-notification.update.sent-at');
});
