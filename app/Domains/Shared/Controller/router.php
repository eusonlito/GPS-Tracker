<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Support\Facades\Route;

Route::get('/shared/{slug?}', Index::class)->name('shared.index');
