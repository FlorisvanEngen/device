<?php

use App\Http\Controllers\PDFController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', function (){
    Session::flush();
    return view('index');
});

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->name('login')->middleware('guest');
Route::post('sessions', [SessionsController::class, 'store'])->middleware('guest');
Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

Route::get('devices/order', [OrderController::class, 'index'])->middleware('admin');
Route::post('devices/order', [OrderController::class, 'store'])->middleware('admin');

Route::post('devices', [DeviceController::class, 'store'])->middleware('admin');
Route::get('devices/create', [DeviceController::class, 'create'])->middleware('admin');
Route::get('devices', [DeviceController::class, 'index'])->middleware('auth');
Route::get('devices/{device}/edit', [DeviceController::class, 'edit'])->middleware('admin');
Route::get('devices/{device}', [DeviceController::class, 'show'])->middleware('auth');
Route::patch('devices/{device}', [DeviceController::class, 'update'])->middleware('admin');
Route::delete('devices/{device}', [DeviceController::class, 'destroy'])->middleware('admin');

Route::delete('devices/pdf/{device}', [PDFController::class, 'destroy'])->middleware('admin');

Route::post('devices/photo/{device}', [PhotoController::class, 'store'])->middleware('admin');
Route::delete('devices/photo/{photo}', [PhotoController::class, 'destroy'])->middleware('admin');
