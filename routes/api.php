<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::post('register', [UserController::class, 'Register']);
Route::post('login', [UserController::class, 'Login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [UserController::class, 'getUserData']);
    Route::post('logout', [UserController::class, 'Logout']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
   
    // Offer CRUD routes for admin
    Route::post('products/{id}/add-offer', [ProductController::class, 'addOffer']);
    Route::post('products/{id}/edit-offer', [ProductController::class, 'editOffer']);
    Route::delete('products/{id}/delete-offer', [ProductController::class, 'deleteOffer']);
    Route::apiResource('products', App\Http\Controllers\ProductController::class);
    Route::apiResource('categories', App\Http\Controllers\CategoryController::class);
 
});

Route::get('/products', [ProductController::class,'getAllProducts']);
Route::get('/categories', [ App\Http\Controllers\CategoryController::class,'getAllCategories']);


use Illuminate\Support\Facades\Artisan;

Route::get('migrate', function () {
    Artisan::call('migrate');
    return 'عاودنا ديرنا المايغراسيون بنجاح!';
});
