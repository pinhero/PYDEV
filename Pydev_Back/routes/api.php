<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AttachementController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisterClientController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\GalleryItemsController;
use App\Http\Controllers\NewsArticlesController;
use App\Http\Controllers\Upload\ImageUploadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:api'])->get('/notifications/unread', function () {
    return response()->json(Auth::user()->unreadNotifications);
});
Route::middleware(['auth:api'])->get('/notifications', function () {
    return response()->json(Auth::user()->notifications);
});

// Authentification
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [RegisterController::class, '__invoke']);
Route::post('register-client', [RegisterClientController::class, '__invoke']);
Route::post('upload-file', [ImageUploadController::class, 'storeFile']);
Route::delete('remove-file/{name}', [ImageUploadController::class, 'deleteFile']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
Route::post('/update-password', [UserController::class, 'updatePassword']);
Route::post('/update-user-information', [UserController::class, 'updateUserInformation']);
Route::post('/validate', [UserController::class, 'changerStatusUserAccount']);
Route::get('/get-media-by-user', [AttachementController::class, 'getMediaByUser']);
Route::post('/store-or-update-piece', [AttachementController::class, 'storeOrUpdate']);
Route::get('/get-media-by-id/{id}', [AttachementController::class, 'getMediaByID']);
Route::post('/changer-status-piece', [AttachementController::class, 'changerStatusMedia'])->middleware('scope:user');
Route::patch('/reset-token/{id}', [ClientController::class, 'updateKey']);
Route::get('/get-media-by-user-id/{id}', [AttachementController::class, 'getMediaByUserId']);
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verify/resend', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response(['message' => 'Compte déjà confirmé!'], 200);
    }
    $request->user()->sendEmailVerificationNotification();
    return response(['message' => 'Lien de vérification envoyé!'], 200);
})->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');

Route::post('/contact', [ContactsController::class, 'store']);
Route::get('/articles', [NewsArticlesController::class, 'getAll']);
Route::get('/article/{id}', [NewsArticlesController::class, 'getOne']);
Route::delete('/article/{id}', [NewsArticlesController::class, 'destroy']);

Route::get('/galeries', [GalleryItemsController::class, 'getAll']);
Route::get('/galerie/{id}', [GalleryItemsController::class, 'getOne']);
Route::delete('/galerie/{id}', [GalleryItemsController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/article', [NewsArticlesController::class, 'store']);
Route::post('/galerie', [GalleryItemsController::class, 'store']);
Route::post('/galerie/{id}', [GalleryItemsController::class, 'update']);
Route::post('/article/{id}', [NewsArticlesController::class, 'update']);

Route::middleware(['auth'])->group(function () {
    Route::middleware(['scope:user'])->delete('/delete-contact/:id', [ContactsController::class, 'destroy']);
    Route::middleware(['scope:user'])->get('/get-contact/{id}', [ContactsController::class, 'show']);
    
    Route::middleware(['scope:user'])->get('/contacts', [ContactsController::class, 'index']);
});

Route::get('/get-all-user-by-role/{role}', [UserController::class, 'getUserByRole']);
Route::get('/get-user-by-status/{status}', [UserController::class, 'findUserByStatus']);
Route::get('/clients', [UserController::class, 'getListeUserWithoutAdmin']);