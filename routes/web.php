<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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
Route::get('/usuarios', [UsersController::class, 'show']);
Route::get('/get-vaucher/{id}', [UsersController::class, 'downloadVoucher']);
Route::get('/mark-as-paid/{id}', [UsersController::class, 'markAsPaid']);
Route::get('/delete-account', [UsersController::class, 'deleteAccountIndex']);
Route::get('/termino-condiciones', [UsersController::class, 'terminosCondiciones']);
Route::delete('/delete-account', [UsersController::class, 'deleteAccountRemove'])->name('delete-account');
