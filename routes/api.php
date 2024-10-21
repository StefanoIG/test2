<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController; 


Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');

    //Routes Users
    Route::get('/users', [UserController::class, 'index'])->middleware('auth:api')->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('auth:api')->name('users.show');   
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('auth:api')->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('auth:api')->name('users.destroy');  

});