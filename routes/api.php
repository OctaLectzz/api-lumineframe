<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CollectionPhotoController;
use App\Http\Controllers\CommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// ---AUTHENTICATION--- //
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::get('/profile', 'profile')->middleware('auth:sanctum');
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth:sanctum');
});

// ---DASHBOARD--- //
Route::prefix('dashboard')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/tag', [TagController::class, 'index']);
    Route::get('/photo', [PhotoController::class, 'index']);
    Route::get('/like', [LikeController::class, 'index']);
    Route::get('/comment', [CommentController::class, 'index']);
    Route::get('/collection', [CollectionController::class, 'index']);
    Route::get('/collectionphoto', [CollectionPhotoController::class, 'index']);
});

// ---USER--- //
Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{user:username}', 'show');
    Route::post('/', 'store')->middleware(['auth:sanctum', 'admin']);
    Route::put('/{user}', 'update');
    Route::delete('/{user}', 'destroy')->middleware(['auth:sanctum', 'admin']);
});

// ---CATEGORY--- //
Route::prefix('category')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{category}', 'show');
    Route::post('/', 'store')->middleware(['auth:sanctum', 'admin']);
    Route::put('/{category}', 'update')->middleware(['auth:sanctum', 'admin']);
    Route::delete('/{category}', 'destroy')->middleware(['auth:sanctum', 'admin']);
});

// ---TAG--- //
Route::prefix('tag')->controller(TagController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{tag}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::put('/{tag}', 'update')->middleware(['auth:sanctum', 'admin']);
    Route::delete('/{tag}', 'destroy')->middleware(['auth:sanctum', 'admin']);
});

// ---PHOTO--- //
Route::prefix('photo')->controller(PhotoController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{photo:photo_number}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::put('/{photo}', 'update')->middleware('auth:sanctum');
    Route::delete('/{photo}', 'destroy')->middleware('auth:sanctum');
    Route::get('/download/{imageFileName}', 'download');
});

// ---LIKE--- //
Route::prefix('like')->controller(LikeController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{like}', 'show');
    Route::post('/', 'store')->middleware(['auth:sanctum', 'admin']);
    Route::put('/{like}', 'update')->middleware(['auth:sanctum', 'admin']);
    Route::delete('/{like}', 'destroy')->middleware(['auth:sanctum', 'admin']);
    Route::get('/user/{id}', 'userlike')->middleware('auth:sanctum');
    Route::put('/photo/{id}', 'like')->middleware('auth:sanctum');
    Route::delete('/photo/{id}', 'dislike')->middleware('auth:sanctum');
});

// ---COMMENT--- //
Route::prefix('comment')->controller(CommentController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{comment}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::put('/{comment}', 'update')->middleware('auth:sanctum');
    Route::delete('/{comment}', 'destroy')->middleware('auth:sanctum');
});

// ---COLLECTION--- //
Route::prefix('collection')->controller(CollectionController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{collection}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::put('/{collection}', 'update')->middleware('auth:sanctum');
    Route::delete('/{collection}', 'destroy')->middleware('auth:sanctum');
    Route::get('/user/{id}', 'usercollection')->middleware('auth:sanctum');
});

// ---COLLECTIONPHOTO--- //
Route::prefix('collectionphoto')->controller(CollectionPhotoController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{collectionphoto}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::put('/{collectionphoto}', 'update')->middleware('auth:sanctum');
    Route::delete('/{collectionphoto}', 'destroy')->middleware('auth:sanctum');
    Route::get('/user/{id}', 'usersave')->middleware('auth:sanctum');
});
