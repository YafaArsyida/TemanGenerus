<?php

use App\Http\Controllers\AksesPengguna;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesaKelompok;
use App\Http\Controllers\GenerasiPenerus;
use App\Http\Controllers\KegiatanGenerus;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PresensiKegiatan;
use App\Http\Controllers\PresensiKegiatanKartu;
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
    // Jika belum login → tampilkan halaman login
    if (!auth()->check()) {
        return redirect()->route('login.index');
    }

    // Jika sudah login → arahkan sesuai role
    $user = auth()->user();

    // if ($user->peran === 'kantin') {
    //     return redirect()->route('smartCanteen.dashboard');
    // }

    return redirect()->route('dashboard.index');
})->name('home');

// login
Route::get('/login', [LoginController::class, 'index'])
    ->name('login.index')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'authenticate'])
    ->name('login.authenticate');

Route::post('/logout', [LoginController::class, 'logOut'])
    ->name('logout');

Route::get('/operasional/presensi-kegiatan-kartu/{token}',  [PresensiKegiatanKartu::class, 'index'])->name('operasional.presensi-kegiatan-kartu');
Route::get('/operasional/presensi-kegiatan/{token}',  [PresensiKegiatan::class, 'index'])->name('operasional.presensi-kegiatan');


Route::middleware(['auth', 'peran:superadmin,administrasi'])->group(function () {
    Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // administrasi
    Route::get('/administrasi/desa-kelompok',  [DesaKelompok::class, 'index'])->name('administrasi.desa-kelompok');
    Route::get('/administrasi/generasi-penerus',  [GenerasiPenerus::class, 'index'])->name('administrasi.generasi-penerus');
    Route::get('/administrasi/kegiatan-generus',  [KegiatanGenerus::class, 'index'])->name('administrasi.kegiatan-generus');

    // operasional

    // sistem
    Route::get('/sistem/akses-pengguna',  [AksesPengguna::class, 'index'])->name('sistem.akses-pengguna');
});