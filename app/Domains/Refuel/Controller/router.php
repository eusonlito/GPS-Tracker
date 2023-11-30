<?php declare(strict_types=1);

namespace App\Domains\Refuel\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth', 'vehicle.available']], static function () {
    Route::get('/refuel', Index::class)->name('refuel.index');
    Route::any('/refuel/create', Create::class)->name('refuel.create');
    Route::any('/refuel/map', Map::class)->name('refuel.map');
    Route::any('/refuel/{id}', Update::class)->name('refuel.update');
});
