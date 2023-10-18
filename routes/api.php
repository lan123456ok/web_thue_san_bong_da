<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\PitchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
Route::get('/pitches', [PitchController::class, 'index'])->name('pitches');

