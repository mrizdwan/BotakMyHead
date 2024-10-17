<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

// Show the payment form
Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');

// Process payment
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

// Handle payment callback
Route::post('/payment/callback', [PaymentController::class, 'handlePaymentCallback'])->name('payment.callback');

// Success page route
Route::get('/payment/success', function () {
    return view('payment.success');
})->name('payment.success');
