<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/getUserTypes', [UserController::class, 'getUserTypes']);
Route::post('/registration', [UserController::class, 'registration']);
Route::post('/verify', [UserController::class, 'verify']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/changePassword', [UserController::class, 'changePassword']);
    Route::post('/updateProfile', [UserController::class, 'updateProfile']);
    Route::post('/uploadAvatar', [UserController::class, 'uploadAvatar']);
    Route::post('/upload', [ImageController::class, 'upload']);
    Route::post('/uploadComment', [ImageController::class, 'uploadComment']);
    //blog
    Route::post('/addCommentToBlog', [BlogController::class, 'addComment']);
});
//blogs
Route::get('/getPosts', [PostController::class, 'getPosts']);
Route::get('/getNearestPosts', [PostController::class, 'getNearestPosts']);
Route::get('/topPosts', [PostController::class, 'topPosts']);
Route::get('/search', [PostController::class, 'search']);
Route::get('/getPostById/{id}', [PostController::class, 'getPostById']);
//posts
Route::get('/getBlogs', [BlogController::class, 'getBlogs']);
Route::get('/getBlogById/{id}', [BlogController::class, 'getBlogById']);

Route::get('/getProfile/{id}', [GuestController::class, 'getProfile']);
Route::get('/getUserComments/{id}', [GuestController::class, 'getUserComments']);

Route::group(['middleware' => ['auth:sanctum', 'abilities:client']], function () {
    Route::post('/createPost', [PostController::class, 'createPost']);
});

Route::group(['middleware' => ['auth:sanctum', 'abilities:rieltor']], function () {
    Route::post('/addRieltorComment', [CommentController::class, 'addRieltorComment']);
});

Route::group(['middleware' => ['auth:sanctum', 'abilities:master']], function () {
    Route::post('/addMasterComment', [CommentController::class, 'addMasterComment']);
});
