<?php declare(strict_types=1);

namespace App\Domains\File\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/file/{id}/{name}', View::class)->name('file.view');
});
