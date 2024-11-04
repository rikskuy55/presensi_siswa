<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GuruMapelController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JadwalMapelController;
use App\Http\Controllers\JadwalMasukController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanHarianController;
use App\Http\Controllers\LaporanMapelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\PresensiPelajaranController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

// Route untuk halaman depan
Route::get('', function () {
    return view('index');
});

// Route untuk menampilkan form login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');

// Route untuk menangani proses login
Route::post('login', [LoginController::class, 'login'])->middleware('guest');

// Route untuk logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rute yang hanya bisa diakses oleh pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Rute yang hanya bisa diakses oleh admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('pengguna', PenggunaController::class);

    // GET route untuk menampilkan form reset password
    Route::get('reset-password', function () {
        return view('admin.data-pengguna.reset-password');
    })->name('admin.reset-password.form');

    // POST route untuk reset password
    Route::post('reset-password', [AdminController::class, 'resetPassword'])->name('admin.reset-password');

    Route::resource('mapel', MapelController::class);
    Route::resource('data-siswa', SiswaController::class);
    Route::resource('data-guru', GuruController::class);
    Route::resource('data-kelas', KelasController::class);
    Route::resource('guru-mapel', GuruMapelController::class);
    Route::resource('jadwal-mapel', JadwalMapelController::class);
    Route::resource('jadwal-masuk', JadwalMasukController::class);

    // Route::get('laporan-harian', [LaporanController::class, 'laporanHarian'])->name('laporan-harian.index');
    // Route::get('laporan-mapel', [LaporanController::class, 'laporanMapel'])->name('laporan-mapel.index');
    // Route::get('laporan-harian/pdf', [LaporanController::class, 'cetakLaporanHarian'])->name('laporan-harian.pdf');
    // Route::get('laporan-mapel/pdf', [LaporanController::class, 'cetakLaporanMapel'])->name('laporan-mapel.pdf');
});

// Rute untuk siswa yang bisa diakses oleh role siswa
Route::middleware(['auth', 'siswa'])->group(function () {
    Route::get('pengaturan-akun', [SiswaController::class, 'index'])->name('siswa.pengaturan-akun');

    Route::get('absensi-harian-masuk', [PresensiController::class, 'showSelfieForm'])->name('siswa.absensi-harian-masuk');
    Route::post('presensi/store', [PresensiController::class, 'store'])->name('siswa.submit-absensi-harian');

    Route::get('absensi-harian-keluar', [PresensiController::class, 'showKeluarForm'])->name('siswa.absensi-harian-keluar');
    Route::post('presensi/keluar/store', [PresensiController::class, 'storeKeluar'])->name('siswa.submit-absensi-keluar');

    // Route untuk presensi mata pelajaran
    Route::get('absensi-mapel-mulai/{mapel_id}', [PresensiPelajaranController::class, 'absensiMulai'])->name('absensi.mapel.mulai');
    Route::post('siswa/submit-absensi-mapel', [PresensiPelajaranController::class, 'storeMulai'])->name('siswa.submit-absensi-mapel');

    Route::get('absensi-mapel-selesai/{mapel_id}', [PresensiPelajaranController::class, 'absensiSelesai'])->name('absensi.mapel.selesai');
    Route::post('siswa.submit-absensi-selesai', [PresensiPelajaranController::class, 'storeSelesai'])->name('siswa.submit-absensi-selesai');

    Route::get('profile', [SiswaController::class, 'profile']);
    Route::get('profile/edit', [SiswaController::class, 'editProfile'])->name('profile.edit');
    Route::put('profile/update', [SiswaController::class, 'updateProfile'])->name('profile.update');

    Route::get('izin', [IzinController::class, 'izin'])->name('izin.index');
    Route::get('form-izin', [IzinController::class, 'showIzinForm']);
    Route::post('izin/submit', [IzinController::class, 'store'])->name('izin.submit');
    Route::get('izin/{id}/edit', [IzinController::class, 'edit'])->name('izin.edit');
    Route::put('izin/{id}', [IzinController::class, 'update'])->name('izin.update');
    Route::delete('izin/{id}', [IzinController::class, 'destroy'])->name('izin.destroy');

    Route::get('histori', [HistoriController::class, 'showHistori'])->name('histori.show');
    Route::get('histori/get', [HistoriController::class, 'getHistori'])->name('histori.get');
});

Route::middleware(['auth', 'isWaliKelas'])->group(function () {
    Route::get('laporan-harian/siswa', [LaporanHarianController::class, 'index'])->name('laporan-harian.wali-kelas');
    Route::post('laporan-harian/print-pdf', [LaporanHarianController::class, 'printPdf'])->name('laporan-harian.print-pdf');
    
//     @if (Auth::user()->role == 'guru' && Auth::user()->guru->kelasWali)
//     <li class="nav-item {{ Request::is('laporan-harian/guru') ? 'active' : '' }}">
//         <a href="{{ route('laporan-harian.wali-kelas') }}">
//             <i class="fas fa-file-alt"></i>
//             <p>Laporan Absensi Harian Siswa</p>
//         </a>
//     </li>
// @endif

    Route::get('laporan-harian/kelas', [LaporanHarianController::class, 'laporanKelas'])->name('laporan-harian.kelas');
    Route::post('laporan-harian/kelas-print', [LaporanHarianController::class, 'printKelasPdf'])->name('laporan-harian.kelas-print');

// @if (Auth::user()->role == 'guru' && Auth::user()->guru->kelasWali)
//     <li class="nav-item {{ Request::is('laporan-harian/kelas') ? 'active' : '' }}">
//             <a href="{{ route('laporan-harian.kelas') }}">
//             <i class="fas fa-file-alt"></i>
//             <p>Laporan Absensi Harian Kelas</p>
//         </a>
//     </li>
// @endif

    Route::get('izin-siswa', [IzinController::class, 'showApproveIzin'])->name('izin.approve-view');
    Route::post('izin-siswa/{id}/approve', [IzinController::class, 'approve'])->name('izin.approve');
    Route::post('izin-siswa/{id}/reject', [IzinController::class, 'reject'])->name('izin.reject');

    Route::get('monitoring-absensi/harian/kelas', [LaporanHarianController::class, 'monitoring'])->name('monitoring-absensi.harian.kelas');
    Route::post('get-daily-attendance', [LaporanHarianController::class, 'getDailyAttendance'])->name('get.daily.attendance');
});

Route::middleware(['auth', 'guru'])->group(function () {
    Route::get('laporan-mapel', [LaporanMapelController::class, 'index'])->name('laporan-mapel.index');
    Route::post('laporan-mapel/print-pdf', [LaporanMapelController::class, 'printPdf'])->name('laporan-mapel.print-pdf');

    Route::get('monitoring-pelajaran', [LaporanHarianController::class, 'monitoringPelajaran'])->name('monitoring-absensi.pelajaran');
    Route::get('get-mata-pelajaran', [LaporanHarianController::class, 'getMataPelajaran']);
    Route::post('get-subject-attendance', [LaporanHarianController::class, 'getSubjectAttendance'])->name('get.subject.attendance');
});
