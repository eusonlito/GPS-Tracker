<?php declare(strict_types=1);

namespace App\Domains\Profile\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::get('/profile', Index::class)->name('profile.index');
