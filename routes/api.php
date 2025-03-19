<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobOfferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'login']);







Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::put('/edit/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});



    Route::prefix('job_offers')->group(function () {
        Route::get('/', [JobOfferController::class, 'index']);
        Route::post('/', [JobOfferController::class, 'store']);
        Route::get('/my-job-offers', [JobOfferController::class, 'myJobOffers']);
        Route::get('/category/{categoryId}', [JobOfferController::class, 'getByCategory']);
        Route::get('/{id}', [JobOfferController::class, 'show']);
        Route::put('/{id}', [JobOfferController::class, 'update']);
        Route::patch('/{id}', [JobOfferController::class, 'update']); 
        Route::delete('/{id}', [JobOfferController::class, 'destroy']);
    });






