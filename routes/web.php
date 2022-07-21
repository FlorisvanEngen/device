<?php

use App\Http\Controllers\PDFController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PhotoController;
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

Route::get('/', [DeviceController::class, 'index']);

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->name('login')->middleware('guest');
Route::post('sessions', [SessionsController::class, 'store'])->middleware('guest');
Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

Route::get('devices/order', [OrderController::class, 'index'])->middleware('auth');
Route::post('devices/order', [OrderController::class, 'store'])->middleware('auth');

Route::post('devices', [DeviceController::class, 'store'])->middleware('auth');
Route::get('devices/create', [DeviceController::class, 'create'])->middleware('auth');
Route::get('devices/{device}/edit', [DeviceController::class, 'edit'])->middleware('auth');
Route::get('devices/{device}', [DeviceController::class, 'show']);
Route::patch('devices/{device}', [DeviceController::class, 'update'])->middleware('auth');
Route::delete('devices/{device}', [DeviceController::class, 'destroy'])->middleware('auth');

Route::delete('devices/pdf/{device}', [PDFController::class, 'destroy'])->middleware('auth');

Route::post('devices/photo/{device}', [PhotoController::class, 'store'])->middleware('auth');
Route::delete('devices/photo/{photo}', [PhotoController::class, 'destroy'])->middleware('auth');
