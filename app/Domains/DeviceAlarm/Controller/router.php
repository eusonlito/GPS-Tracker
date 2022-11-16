<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/device-alarm', Index::class)->name('device-alarm.index');
});
