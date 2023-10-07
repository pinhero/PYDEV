<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AttachementController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
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
Route::post('/changer-status-piece', [AttachementController::class, 'changerStatusMedia'])->middleware('scope:admin');
Route::get('/get-media-by-user-id/{id}', [AttachementController::class, 'getMediaByUserId']);
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verify/resend', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response(['message' => 'Compte déjà confirmé!'], 200);
    }
    $request->user()->sendEmailVerificationNotification();
    return response(['message' => 'Lien de vérification envoyé!'], 200);
})->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
