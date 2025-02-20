<?php

declare(strict_types=1);

use App\Domains\Role\Controller\Index;
use App\Domains\Role\Controller\Edit;
use App\Domains\Role\Controller\Create;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], function () {
    Route::get('/role', Index::class)->name('role.index');
    // Route::get('/role/{id}/edit', Edit::class)->name('role.edit');
    Route::get('/role/create', Create::class)->name('role.create');
});
