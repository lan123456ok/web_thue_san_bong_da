<?php

use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\PitchController;
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
    Route::post('/create', [CampaignController::class, 'store'])->name('store');
    Route::post('/import-csv', [CampaignController::class, 'importCSV'])->name('import_csv');
});
Route::group([
    'as' => 'pitches.',
    'prefix' => 'pitches',
], static function () {
    Route::get('/', [PitchController::class, 'index'])->name('index');
    Route::get('/create', [PitchController::class, 'create'])->name('create');
});
