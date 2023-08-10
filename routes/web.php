<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\{Route, Auth};
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'verified']);

Route::get('/api-product', [ProductController::class, 'index'])->name('api-product')->middleware(['auth', 'verified']);


Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', [VerificationController::class, 'send'])
->middleware(['auth', 'throttle:6,1'])
->name('verification.resend');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
->middleware(['auth', 'signed', 'throttle:6,1'])
->name('verification.verify');

Route::get('/products', function () {
    return view('pages.products.index');
})->middleware('auth', 'verified')->name('products');

Auth::routes();
