<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {

    return redirect()->route('pos.index');
});

Route::get('/pos', [PosController::class, 'index'])->name('pos.index');

Route::get('/jalankan-schedule', [ScheduleController::class, 'index'])->name('jalankan-schedule-index');
Route::post('/jalankan-schedule', [ScheduleController::class, 'run'])->name('jalankan-schedule');
Route::get('/products', [ProductController::class, 'getProducts'])->name('products.index');
Route::get('/transactions', [TransactionController::class, 'getTransaction'])->name('transactions.index');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/pos/checkout', [TransactionController::class, 'checkout'])->name('pos.checkout');
Route::post('/transaction/store', [TransactionController::class, 'store']);
Route::get('/manajemen-karyawan', [EmployeeController::class, 'index'])->name('manajemen-karyawan.index');
Route::get('/manajemen-karyawan/list', [EmployeeController::class, 'list'])->name('manajemen-karyawan.list');
Route::post('/manajemen-karyawan', [EmployeeController::class, 'store'])->name('manajemen-karyawan.store');
Route::put('/manajemen-karyawan/{id}', [EmployeeController::class, 'update'])->name('manajemen-karyawan.update');