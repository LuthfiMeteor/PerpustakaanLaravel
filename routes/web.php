<?php

use App\Http\Controllers\Dashboard\BukuController;
use App\Http\Controllers\Dashboard\KategoriController;
use App\Http\Controllers\dashboard\LaporanController;
use App\Http\Controllers\Dashboard\PetugasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Models\BukuModel;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    $buku =  DB::table('buku')->first();
    return view('landingPage/heroPage', compact('buku'));
})->name('landing');

Auth::routes();

route::group(['middleware' => ['role:admin|petugas']], function () {
    route::prefix('dashboard/')->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        // Managemen Kategori
        route::get('Managemen-Kategori', [KategoriController::class, 'index'])->name('managemenKategori');
        route::post('tambah-kategori',  [KategoriController::class, 'create'])->name('tambahKategori');
        route::get('edit-kategori',  [KategoriController::class, 'edit'])->name('editKategori');
        route::post('update-kategori',  [KategoriController::class, 'update'])->name('updateKategori');
        route::post('delete-kategori',  [KategoriController::class, 'delete'])->name('deleteKategori');

        // Managemen Buku
        route::get('managemen-buku', [BukuController::class, 'index'])->name('managemenBuku');
        route::post('tambah-buku', [BukuController::class, 'create'])->name('tambahBuku');
        route::get('edit-buku/{id}', [BukuController::class, 'edit'])->name('editBuku');
        route::post('update-buku/{id}', [BukuController::class, 'update'])->name('updateBuku');
        route::post('delete-buku', [BukuController::class, 'delete'])->name('deleteBuku');

        // Laporan
        route::get('laporan', [LaporanController::class, 'index'])->name('laporanBuku');

        route::group(['middleware' => ['role:admin']], function () {
            // Managemen Petugas
            route::get('managemen-petugas', [PetugasController::class, 'index'])->name('managemenPetugas');
            route::post('tambah-petugas', [PetugasController::class, 'store'])->name('tambahPetugas');
            route::get('edit-petugas/{id}', [PetugasController::class, 'edit'])->name('editPetugas');
            route::post('update-petugas/{id}', [PetugasController::class, 'update'])->name('updatePetugas');
            route::post('delete-petugas', [PetugasController::class, 'destroy'])->name('deletePetugas');
        });
    });
});

route::group(['middleware' => 'role:user'], function () {
    route::get('/DetailBuku/baca/{id}', [LandingPageController::class, 'baca'])->name('bacaBuku');
    route::post('daftar-member', [LandingPageController::class, 'daftarMember'])->name('daftarMember');
    route::post('favorit', [LandingPageController::class, 'favorit'])->name('favorit');
});

route::group(['middleware' => 'auth'], function () {
});

route::get('/buku', [LandingPageController::class, 'bukuPage'])->name('bukuPage');
route::get('/DetailBuku/{id}', [LandingPageController::class, 'detailBuku'])->name('detailBuku');
