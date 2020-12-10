<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/sw', function () {
    return '2222';
});



//code for rest api version 1.0  url= /api/v1/[]
 Route::group(['prefix' => 'v1'], function() {
     Route::get('/', function () {
         dd('3333');
     });

     Route::get('/rr', function () {
         dd('2222');
     });
     //Route::get('/users', [UserController::class, 'index']);

     //Route::resource('categories', CategoryController::class);
     Route::get('categories/{id}/threads', [CategoryController::class,'threadsBelongToCategory']);
     Route::resource('categories', CategoryController::class,[
         'except' => ['create','edit']
     ]);

     Route::get('threads/search', [ThreadController::class, 'threadSearch']);
     Route::get('threads/{id}/posts', [ThreadController::class, 'getThreadPosts']);
     Route::resource('threads', ThreadController::class,[
         'except' => ['create','edit']
     ]);

     Route::resource('posts', PostController::class,[
         'except' => ['create','edit','index']
     ]);

     Route::post('users', [AuthController::class, 'store']);

     Route::get('users/{id}', [UserController::class, 'show']);
     Route::get('users', [UserController::class, 'index']);
     Route::patch('users/{id}', [UserController::class, 'update']);

//     Route::resource('photos', PhotoController::class)->only([
//         'index', 'show'
//     ]);
//
//     Route::resource('photos', PhotoController::class)->except([
//         'create', 'store', 'update', 'destroy'
//     ]);



//     Route::post('user', [
//         'uses' => 'AuthController@store'
//     ]);

//     Route::post('user/signin', [
//         'uses' => 'AuthController@signin'
//     ]);



});





