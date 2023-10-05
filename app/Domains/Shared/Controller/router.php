<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Support\Facades\Route;

Route::get('/shared/device/{uuid}', Device::class)->name('shared.device');
Route::get('/shared/trip/{uuid}', Trip::class)->name('shared.trip');
Route::get('/shared/{slug}', Index::class)->name('shared.index');
