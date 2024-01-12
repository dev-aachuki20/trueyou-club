<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\LoginRegisterController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\SocialMediaController;
use App\Http\Controllers\Api\User\HomeController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\CommanController;
use App\Http\Controllers\Api\User\TwilioController;
use App\Http\Controllers\Api\User\PaymentController;
use App\Http\Controllers\Api\User\StripeWebhookController;
use App\Http\Controllers\Api\User\SeminarController;



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

Route::controller(LoginRegisterController::class)->group(function () {

    Route::post('register', 'register');

    Route::post('login', 'login');

    Route::post('forgot-password', 'forgotPassword');

    Route::post('reset-password', 'resetPassword');

    Route::get('/email/verify/{id}/{hash}', 'verifyEmail');

    Route::post('verify-set-password', 'verifyBuyerEmailAndSetPassword');

    Route::get('get-email/{id}', 'getEmail');
});

Route::controller(SocialMediaController::class)->group(function () {

    Route::post('handle-google', 'handleGoogle');

    Route::post('handle-facebook', 'handleFacebook');
});


Route::group(['middleware' => ['api', 'auth:sanctum']], function () {

    Route::post('logout', [LogoutController::class, 'logout']);

    Route::get('user-details', [ProfileController::class, 'userDetails']);

    Route::post('update-profile', [ProfileController::class, 'updateProfile']);

    Route::post('update-buyer-search-status', [ProfileController::class, 'updateBuyerSearchStatus']);

    Route::post('update-buyer-contact-pref', [ProfileController::class, 'updateBuyerContactPreference']);

    Route::post('update-buyer-profile-image', [ProfileController::class, 'updateBuyerProfileImage']);

    // Route::post('send-sms', [TwilioController::class, 'sendSms']);


    // Route::post('/checkout-session', [PaymentController::class, 'createCheckoutSession']);

    // Route::post('/checkout-success', [PaymentController::class, 'checkoutSuccess']);
    Route::get('/get-all-seminars', [SeminarController::class, 'getAllSeminar']);
});

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleStripeWebhook']);
