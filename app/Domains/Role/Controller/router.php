<?php

declare(strict_types=1);

namespace App\Domains\Role\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/role', Index::class)->name('role.index');
    Route::any('/role/create', Create::class)->name('role.create');
    Route::any('/role/{id}', Update::class)->name('role.update');
    Route::any('/role/{id}/role-notification', UpdateRoleNotification::class)->name('role.update.role-notification');
    Route::any('/role/{id}/vehicle', UpdateVehicle::class)->name('role.update.vehicle');
    Route::any('/role/{id}/boolean/{column}', UpdateRoleBoolean::class)->name('role.update.boolean');
});
