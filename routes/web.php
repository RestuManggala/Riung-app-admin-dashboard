<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MandiriController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Dashboard\AkunController;
use App\Http\Controllers\Dashboard\LaporanController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\TambahDataController;
use App\Http\Controllers\Dashboard\PosisiSaldoController;
use App\Http\Controllers\Dashboard\UploadExcelController;
use App\Http\Controllers\Dashboard\RekeningKoranController;

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
// Route::middleware(['isLogin'])->group(function () {
    Route::get('/', [LoginController::class, 'index']);
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login/auth', [LoginController::class, 'authentication'])->name('authentication');
// });

Route::middleware(['isBos'])->group(function () {
    Route::get('/akun', [AkunController::class, 'index'])->name('akun');
    Route::post('/akun/update/{id}', [AkunController::class, 'update'])->name('edit-akun');
    Route::get('/akun/hapus/{id}', [AkunController::class, 'destroy'])->name('hapus-akun');
    Route::post('/akun/simpan-akun', [AkunController::class, 'store'])->name('simpan-akun');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    // Route::get('/category/{id}', [LaporanController::class, 'show'])->name('show-data');
    Route::post('/laporan/update/{id}', [LaporanController::class, 'update'])->name('edit-data');
    Route::get('/laporan/hapus/{id}', [LaporanController::class, 'destroy'])->name('hapus-data');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('export-excel');
    Route::get('/laporan/export-category/{id}', [LaporanController::class, 'exportRek'])->name('export-category');
    Route::get('/laporan/download', [LaporanController::class, 'getDownload'])->name('template-download');
    Route::post('/laporan/simpan-data', [LaporanController::class, 'store'])->name('simpan-data');
    Route::post('/laporan/simpan-excel', [LaporanController::class, 'import'])->name('simpan-excel');

    Route::get('/rekening-koran', [RekeningKoranController::class, 'index'])->name('rekening-koran');
    Route::post('/rekening-koran/simpan-rekening', [RekeningKoranController::class, 'store'])->name('simpan-rekening');
    Route::post('/rekening-koran/update-rekening/{id}', [RekeningKoranController::class, 'update'])->name('edit-rekening');
    Route::get('/rekening-koran/hapus-rekening/{id}', [RekeningKoranController::class, 'destroy'])->name('hapus-rekening');
    Route::post('/rekening-koran/update-rekening/{id}', [RekeningKoranController::class, 'update'])->name('edit-rekening');
    Route::get('/rekening-koran/download-rekening/{id}', [RekeningKoranController::class, 'getDownload'])->name('download-rekening');

    Route::get('/posisi-saldo', [PosisiSaldoController::class, 'index'])->name('posisi-saldo');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

