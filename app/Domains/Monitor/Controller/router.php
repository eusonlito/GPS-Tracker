<?php declare(strict_types=1);

namespace App\Domains\Monitor\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin']], static function () {
    Route::get('/monitor', Index::class)->name('monitor.index');
    Route::get('/monitor/installation', Installation::class)->name('monitor.installation');
    Route::get('/monitor/database', Database::class)->name('monitor.database');
    Route::get('/monitor/log/{path}/{file}/download', LogFileDownload::class)->name('monitor.log.file.download');
    Route::get('/monitor/log/{path}/{file}', LogFile::class)->name('monitor.log.file');
    Route::get('/monitor/log/{path?}', Log::class)->name('monitor.log.path');
    Route::any('/monitor/queue/{name?}', Queue::class)->name('monitor.queue');
    Route::get('/monitor/requirements', Requirements::class)->name('monitor.requirements');
});
