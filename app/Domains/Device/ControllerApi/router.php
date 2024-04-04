<?php declare(strict_types=1);

namespace App\Domains\Device\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::get('/device', Index::class)->name('device.index');
Route::post('/device/create', Create::class)->name('device.create');
Route::patch('/device/{id}', Update::class)->name('device.update');
Route::delete('/device/{id}', Delete::class)->name('device.delete');
