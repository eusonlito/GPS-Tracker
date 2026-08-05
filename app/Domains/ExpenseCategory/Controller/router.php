<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/expense-category', Index::class)->name('expense-category.index');
    Route::any('/expense-category/create', Create::class)->name('expense-category.create');
    Route::any('/expense-category/{id}', Update::class)->name('expense-category.update');
});
