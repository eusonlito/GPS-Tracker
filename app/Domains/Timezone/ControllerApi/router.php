<?php declare(strict_types=1);

namespace App\Domains\Timezone\ControllerApi;

use Illuminate\Support\Facades\Route;

Route::get('/timezone', Index::class)->name('timezone.index');
