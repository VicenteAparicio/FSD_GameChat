<?php

use App\Http\Controllers\PartyController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\userController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\MembershipController;
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


Route::middleware('auth:api')->group(function() {
    // Route::resource('parties', PartyController::class);
    // PARTY ROUTES 
    Route::post('createparty', [PartyController::class, 'store']);
    Route::post('deleteparty', [PartyController::class, 'destroy']);
    Route::post('updateparty', [PartyController::class, 'update']);
    
    Route::get('allparties', [PartyController::class, 'index']);
    Route::post('partiesbyowner', [PartyController::class, 'partiesByOwner']);
    Route::post('partiesbygame', [PartyController::class, 'partiesByGame']);
    Route::post('partybyid', [PartyController::class, 'partyById']);
    
    // MEMBERSHIP ROUTES
    Route::post('addmember', [MembershipController::class, 'store']);

    // MESSAGE ROUTES
    Route::post('newmessage', [MessageController::class, 'store']);

    // USER ROUTES
    Route::get('allusers', [userController::class, 'allusers']);

    // GAME ROUTES
    Route::post('addgame', [GameController::class, 'store']);
    Route::post('deletegame', [GameController::class, 'destroy']);
    Route::post('updategame', [GameController::class, 'update']);
    Route::get('allgames', [GameController::class, 'index']);
    
    // return $request->user();
});
