<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BoatController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// api/login
// Route::post('/login', [App\Http\Controllers\Api\ApiController::class, 'login']);
// Route::post('/registration', [App\Http\Controllers\Api\ApiController::class, 'registration']);
// Route::post('/add-order-transactions', [App\Http\Controllers\Api\ApiController::class, 'addOrderTransactions']);
// Route::post('/add-boat', [App\Http\Controllers\Api\ApiController::class, 'addBoat']);
// Route::get('/models/{slug}', [App\Http\Controllers\Api\ApiController::class, 'getModelsListing'])->name('models');

  
  
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
  
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
     
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('boats', BoatController::class);
});