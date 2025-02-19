<?php declare(strict_types=1);

use App\Domains\Role\Controller\Index;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth']], function () {
    Route::get('/role', Index::class)->name('role.index');
});
