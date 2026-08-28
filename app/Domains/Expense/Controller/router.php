<?php declare(strict_types=1);

namespace App\Domains\Expense\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth', 'vehicle.available']], static function () {
    Route::get('/expense', Index::class)->name('expense.index');
    Route::any('/expense/create', Create::class)->name('expense.create');
    Route::get('/expense/stat', Stat::class)->name('expense.stat');
    Route::any('/expense/{id}', Update::class)->name('expense.update');
});
