<?php declare(strict_types=1);

namespace App\Domains\Vehicle\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::get('/vehicle', Index::class)->name('vehicle.index');
Route::post('/vehicle/create', Create::class)->name('vehicle.create');
Route::patch('/vehicle/{id}', Update::class)->name('vehicle.update');
Route::delete('/vehicle/{id}', Delete::class)->name('vehicle.delete');
