<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/alarm', Index::class)->name('alarm.index');
});
