<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\FakeCarController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RentController;
use Illuminate\Support\Facades\Route;

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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::resource('/brand', BrandController::class);
Route::resource('/faq', FAQController::class);
Route::resource('/blog', BlogController::class);
Route::resource('/model', ModelController::class);
Route::resource('/like',FavoriteController::class);
Route::resource('/rent',RentController::class);
Route::resource('/car', CarController::class)->parameters([
    'car' => 'id'
]);
Route::post('/fake-car',[FakeCarController::class,'fake']);
Route::resource('/comment', CommentController::class);

Route::resource('/location', LocationController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('/user', UserController::class);
    Route::resource('/post', PostController::class);
});
