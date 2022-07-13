<?php

use App\Http\Controllers\DeviceController;
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

Route::get('/', function (){
    return view('index');
});

Route::post('devices', [DeviceController::class, 'store']);
Route::get('devices/create', [DeviceController::class, 'create']);
Route::get('devices', [DeviceController::class, 'index']);
Route::get('devices/{device}/edit', [DeviceController::class, 'edit']);
Route::get('devices/{device}', [DeviceController::class, 'show']);
Route::patch('devices/{device}', [DeviceController::class, 'update']);
Route::delete('devices/{device}', [DeviceController::class, 'destroy']);
