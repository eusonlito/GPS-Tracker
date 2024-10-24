<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin']], static function () {
    Route::get('/monitor', Index::class)->name('monitor.index');
    Route::get('/monitor/installation', Installation::class)->name('monitor.installation');
    Route::get('/monitor/database', Database::class)->name('monitor.database');
    Route::get('/monitor/log', Log::class)->name('monitor.log');
    Route::any('/monitor/queue/{name?}', Queue::class)->name('monitor.queue');
    Route::get('/monitor/requirements', Requirements::class)->name('monitor.requirements');
});
