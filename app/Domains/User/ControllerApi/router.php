<?php

declare(strict_types=1);

namespace App\Domains\User\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin-mode']], static function () {
    Route::get('/user', Index::class)->name('user.index');
    Route::post('/user/create', Create::class)->name('user.create');
    Route::patch('/user/{id}', Update::class)->name('user.update');
    Route::delete('/user/{id}', Delete::class)->name('user.delete');
});

Route::prefix('')->group(function () {
    Route::apiResource('roles', \App\Domains\User\ControllerApi\RoleController::class);
});
