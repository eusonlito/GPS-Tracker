<?php declare(strict_types=1);

namespace App\Domains\Language\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::get('/language', Index::class)->name('language.index');
