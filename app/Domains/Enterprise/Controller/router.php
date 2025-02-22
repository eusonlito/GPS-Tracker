<?php declare(strict_types=1);
namespace App\Domains\Enterprise\Controller;

use Illuminate\Support\Facades\Route;
use App\Domains\Enterprise\Controller\Index as EnterpriseIndex;

Route::group(['middleware' => ['user-auth']], static function () {
    Route::get('/enterprise', EnterpriseIndex::class)->name('enterprise.index');

});
