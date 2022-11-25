<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/device', Index::class)->name('device.index');
    Route::any('/device/create', Create::class)->name('device.create');
    Route::any('/device/{id}', Update::class)->name('device.update');
    Route::any('/device/{id}/alarm', UpdateAlarm::class)->name('device.update.alarm');
    Route::any('/device/{id}/alarm/create', UpdateAlarmCreate::class)->name('device.update.alarm.create');
    Route::any('/device/{id}/alarm/{alarm_id}', UpdateAlarmUpdate::class)->name('device.update.alarm.update');
    Route::any('/device/{id}/alarm/{alarm_id}/boolean/{column}', UpdateAlarmUpdateBoolean::class)->name('device.update.alarm.update.boolean');
    Route::any('/device/{id}/alarm-notification', UpdateAlarmNotification::class)->name('device.update.alarm-notification');
    Route::any('/device/{id}/device-message', UpdateDeviceMessage::class)->name('device.update.device-message');
    Route::any('/device/{id}/device-message/create', UpdateDeviceMessageCreate::class)->name('device.update.device-message.create');
    Route::any('/device/{id}/device-message/{device_message_id}', UpdateDeviceMessageUpdate::class)->name('device.update.device-message.update');
});
