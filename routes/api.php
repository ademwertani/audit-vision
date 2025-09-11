<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TeamController;

Route::get('/team', [TeamController::class, 'index']);
