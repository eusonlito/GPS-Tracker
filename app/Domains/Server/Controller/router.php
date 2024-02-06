<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['user-auth-admin-mode']], static function () {
    Route::any('/server', Index::class)->name('server.index');
    Route::any('/server/create', Create::class)->name('server.create');
    Route::any('/server/status', Status::class)->name('server.status');
    Route::any('/server/{id}', Update::class)->name('server.update');
    Route::any('/server/{id}/boolean/{column}', UpdateBoolean::class)->name('server.update.boolean');
    Route::any('/server/{id}/parser', UpdateParser::class)->name('server.update.parser');
});
