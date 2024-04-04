<?php declare(strict_types=1);

namespace App\Domains\Help\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::get('/help', Index::class)->name('help.index');
Route::get('/help/{name}', Detail::class)->name('help.detail');
