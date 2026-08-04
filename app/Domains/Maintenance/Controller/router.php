<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth', 'vehicle.available']], static function () {
    Route::get('/maintenance', Index::class)->name('maintenance.index');
    Route::any('/maintenance/create', Create::class)->name('maintenance.create');
    Route::any('/maintenance/{id}', Update::class)->name('maintenance.update');
    Route::any('/maintenance/{id}/item', UpdateItem::class)->name('maintenance.update.item');
});
