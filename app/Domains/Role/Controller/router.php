<?php

declare(strict_types=1);

use App\Domains\Role\Controller\Index as RoleIndex;
use App\Domains\Role\Feature\Controller\Index as FeatureIndex;
use App\Domains\Role\Controller\Create;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], function () {
    Route::get('/role', RoleIndex::class)
        ->name('role.index');
    Route::get('/role/create', Create::class)->name('role.create');
    Route::post('/role/store', [Create::class, 'store'])->name('role.store');
    Route::get('/role/feature', FeatureIndex::class)
        ->name('role.feature.index')
        ->middleware('user.role.feature.access:role-feature'); // Chỉ manager mới có quyền
});
