<?php

use App\Http\Controllers\Api\{AuthController, ProfileController, AddressController, ProductController,ServiceFeeController,OrderController,StripeController,WebHookController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify_email', [AuthController::class, 'verify_email']);
Route::post('/verify_phone', [AuthController::class, 'verify_phone']);
Route::post('/forget_password', [AuthController::class, 'forget_password']);
Route::post('/match_otp', [AuthController::class, 'match_otp']);

Route::get('/countries', [AddressController::class, 'countries']);
Route::get('/states', [AddressController::class, 'states']);

Route::middleware('auth:api')->group(function () {

    Route::post('/change_password', [AuthController::class, 'change_password']);
    Route::post('/update_password', [AuthController::class, 'update_password']);
    Route::put('/update_profile', [ProfileController::class, 'update_profile']);
    Route::get('/my_profile', [ProfileController::class, 'my_profile']);
    Route::put('/switch_profile', [ProfileController::class, 'switch_profile']);
    Route::get('/favourites', [ProfileController::class, 'favourites']);
    Route::get('/wishlist', [ProfileController::class, 'wishlist']);

    Route::resource('addresses', AddressController::class);

    Route::post('/add_media_files', [ProductController::class, 'add_media_files']);
    Route::post('/remove_media', [ProductController::class, 'remove_media']);
    Route::resource('products', ProductController::class);

    Route::put('/product_status/{id}', [ProductController::class, 'product_status']);
    Route::post('/favourite', [ProductController::class, 'favourite']);
    Route::post('/wishlist', [ProductController::class, 'wishlist']);

    Route::get('/categories', [ProductController::class, 'categories']);
    Route::get('/types', [ProductController::class, 'types']);
    Route::get('/days', [ProductController::class, 'days']);
    Route::get('/times', [ProductController::class, 'times']);

    Route::post('/create_payment_method', [StripeController::class, 'create_payment_method']);
    Route::post('/attach_payment_method', [StripeController::class, 'attach_payment_method']);
    Route::get('/get_cards', [StripeController::class, 'get_cards']);

    Route::post('/create_payment_intent', [StripeController::class, 'create_payment_intent']);
    Route::post('/confirm_payment', [StripeController::class, 'confirm_payment']);


    Route::get('/service_fee_percentage', [ServiceFeeController::class, 'service_fee_percentage']);


    Route::get('/availiability/{id}', [OrderController::class, 'availiability']);
    Route::post('/order', [OrderController::class, 'order']);



});

Route::post('/stripe_webhook', [WebHookController::class, 'stripe_webhook']);
