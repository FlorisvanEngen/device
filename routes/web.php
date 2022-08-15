<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create.blade.php something great!
|
*/


Route::get('/', [DeviceController::class, 'index'])->name('home');
Route::get('devices/{device}', [DeviceController::class, 'show'])->whereNumber('device');
Route::get('media/{filename}', [MediaController::class, 'show']);

Route::get('contact', [ContactController::class, 'index']);
Route::post('contact', [ContactController::class, 'sendMail'])->name('contact.store');
Route::get('contact/{category}', [ContactController::class, 'getDevices']);

Route::middleware(['guest'])->group(function () {
    Route::get('register', [RegisterController::class, 'create']);
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('login', [SessionsController::class, 'create'])->name('login');
    Route::post('sessions', [SessionsController::class, 'store'])->name('login.store');
});

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [SessionsController::class, 'destroy'])->name('login.destroy');

    Route::get('devices/order', [OrderController::class, 'index']);
    Route::post('devices/order', [OrderController::class, 'store'])->name('devices.order.store');
    Route::get('devices/order/{category}', [OrderController::class, 'show']);

    Route::resource('devices', DeviceController::class)->except(['index', 'show']);

    Route::post('media/{device}', [MediaController::class, 'store'])->name('media.store');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
});
