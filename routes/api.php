<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\PitchController;
use App\Http\Controllers\SubPitchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
Route::post('/campaigns/slug', [CampaignController::class, 'generateSlug'])->name('campaigns.slug.generate');
Route::get('/campaigns/slug', [CampaignController::class, 'checkSlug'])->name('campaigns.slug.check');
Route::get('/pitches', [PitchController::class, 'index'])->name('pitches');
Route::get('/subpitches', [SubPitchController::class, 'index'])->name('subpitches');
