<?php declare(strict_types=1);

namespace App\Domains\Device\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::get('/device', Index::class)->name('device.index');
