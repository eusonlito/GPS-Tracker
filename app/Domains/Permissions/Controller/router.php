<?php declare(strict_types=1);

use App\Domains\Permissions\Controller\Index as PermissionIndex;
use App\Domains\Permissions\Controller\Create as PermissionCreate;
use Illuminate\Support\Facades\Route;

Route::middleware(['user-auth'])->group(function () {
    Route::get('/permissions', PermissionIndex::class)->name('permissions.index');

    Route::get('/permissions/feature', [PermissionIndex::class, 'feature'])->name('permissions.feature.index');
    Route::get('/permissions/create', PermissionCreate::class)->name('permissions.create');
});