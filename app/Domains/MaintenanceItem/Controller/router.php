<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/maintenance-item', Index::class)->name('maintenance-item.index');
    Route::any('/maintenance-item/create', Create::class)->name('maintenance-item.create');
    Route::any('/maintenance-item/{id}', Update::class)->name('maintenance-item.update');
    Route::any('/maintenance-item/{id}/maintenance', UpdateMaintenance::class)->name('maintenance-item.update.maintenance');
});
