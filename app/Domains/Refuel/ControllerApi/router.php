<?php declare(strict_types=1);

namespace App\Domains\Refuel\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::get('/refuel', Index::class)->name('refuel.index');
Route::post('/refuel/create', Create::class)->name('refuel.create');
Route::patch('/refuel/{id}', Update::class)->name('refuel.update');
Route::delete('/refuel/{id}', Delete::class)->name('refuel.delete');
