<?php declare(strict_types=1);

namespace App\Domains\Trip\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::get('/trip', Index::class)->name('trip.index');
Route::get('/trip/{id}/position', Position::class)->name('trip.position');
Route::patch('/trip/{id}', Update::class)->name('trip.update');
Route::delete('/trip/{id}', Delete::class)->name('trip.delete');
