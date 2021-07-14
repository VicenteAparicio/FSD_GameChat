<?php

use App\Http\Controllers\PartyController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PassportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::post('game', [GameController::class, 'store']);

Route::middleware('auth:api')->group(function() {
    // Route::resource('parties', PartyController::class);
    Route::post('createparty', [PartyController::class, 'store']);
    Route::post('partyowner', [PartyController::class, 'partyowner']);
    Route::post('gameparty', [PartyController::class, 'gameparty']);
    Route::post('partyid', [PartyController::class, 'partyid']);
    Route::post('newmessage', [MessageController::class, 'store']);
    // return $request->user();
});
