<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;

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



Route::post('/register', [UserAuthController::class, 'register'])->middleware('client');
Route::post('/login', [UserAuthController::class, 'login'])->middleware('client');

Route::middleware('auth:api')->group(function(){

  Route::post('send-invitation', 'API\InvitationController@invitation');
  Route::post('/{refererID}/register/link', 'API\InvitationController@register');
  Route::post('/account-activate', 'API\InvitationController@activate');

  Route::post('/logout', [UserAuthController::class, 'logout']);
});