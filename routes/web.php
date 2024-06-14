<?php

use App\Http\Controllers\UserDetailController;
use Illuminate\Support\Facades\Route;

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

Route::get('/check-account', [UserDetailController::class, 'checkAccount'])->name('check.account');

Route::get('/check-account-number/{accountNumber}', [UserDetailController::class, 'checkAccountNumber'])->name('checkAccountNumber');

Route::get('/check-account-number-phone/{OldaccountNumber}', [UserDetailController::class, 'checkAccountPhone'])->name('checkAccountNumberOld');
