<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('donate/stripe', [StripePaymentController::class, 'stripe'])->name('stripe.get');
Route::post('payment/stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

Route::get('donate/paypal', [PaypalPaymentController::class, 'payWithPaypal'])->name('paywithpaypal');
Route::post('payment/paypal', [PaypalPaymentController::class, 'postPaymentWithpaypal'])->name('paypal');
Route::get('paypal', [PaypalPaymentController::class, 'getPaymentStatus'])->name('status');

Route::get('donation/list', [DonationController::class, 'getAllDonation'])->name('donation.list');
