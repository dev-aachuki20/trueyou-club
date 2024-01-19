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
use App\Http\Controllers\Api\User\WebinarController;
use App\Http\Controllers\Api\User\PostController;
use App\Http\Controllers\Api\User\PageController;
use App\Http\Controllers\Api\User\ContactController;



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

    Route::post('update-profile-image', [ProfileController::class, 'changeProfileImage']);

    Route::post('update-user-status', [ProfileController::class, 'updateStatus']);

    Route::post('update-password', [ProfileController::class, 'updatePassword']);


    // Route::post('send-sms', [TwilioController::class, 'sendSms']);

    // Route::post('/checkout-session', [PaymentController::class, 'createCheckoutSession']);

    // Route::post('/checkout-success', [PaymentController::class, 'checkoutSuccess']);

    Route::get('/get-all-webinars', [WebinarController::class, 'index']);

    Route::post('/post-task', [HomeController::class, 'store']);

    Route::get('/today-quote-percentage', [HomeController::class, 'index']);

    Route::get('/lead-board-user-list', [HomeController::class, 'leadBoardUser']);
});


Route::get('/get-site-settings-details', [CommanController::class, 'siteSettingDetails']);
Route::get('/get-latest-records/{pageName}', [CommanController::class, 'getLatestRecords']);


Route::get('/get-all-seminars', [SeminarController::class, 'index']);

Route::get('/get-posts/{postType}', [PostController::class, 'index']);
Route::get('/post/{slug}', [PostController::class, 'show']);

Route::get('/page/{slug}', [PageController::class, 'getPageDetails']);

Route::post('/contact-us', [ContactController::class, 'store']);


Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleStripeWebhook']);
