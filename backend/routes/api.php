<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ApplicationController;

Route::apiResource('offers', OfferController::class);

Route::get('applications', [ApplicationController::class, 'index']);
Route::post('applications', [ApplicationController::class, 'store']);
Route::get('applications/{application}', [ApplicationController::class, 'show']);

Route::put('applications/{id}/status', [ApplicationController::class, 'changeStatus']);
Route::post('applications/{id}/comment', [ApplicationController::class, 'addComment']);
