<?php

use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.master');
})->name('welcome');

Route::group([
    'as' => 'users.',
    'prefix' => 'users',
], static function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});
Route::group([
    'as' => 'campaigns.',
    'prefix' => 'campaigns',
], static function () {
    Route::get('/', [CampaignController::class, 'index'])->name('index');
    Route::get('/create', [CampaignController::class, 'create'])->name('create');
    Route::post('/import-csv', [CampaignController::class, 'importCSV'])->name('import_csv');
});

