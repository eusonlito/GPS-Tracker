<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/alarm-notification', Index::class)->name('alarm-notification.index');
    Route::any('/alarm-notification/{id}/delete', Delete::class)->name('alarm-notification.delete');
    Route::any('/alarm-notification/{id}/closed-at', UpdateClosedAt::class)->name('alarm-notification.update.closed-at');
    Route::any('/alarm-notification/{id}/sent-at', UpdateSentAt::class)->name('alarm-notification.update.sent-at');
});
