<?php

use App\Http\Controllers\Dashboard\BukuController;
use App\Http\Controllers\Dashboard\KategoriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use FontLib\Table\Type\name;
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
    return view('landingPage/heroPage');
})->name('landing');

Auth::routes();

route::prefix('dashboard/')->middleware('role:admin')->group(function () {
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
});

route::get('/buku', [LandingPageController::class, 'bukuPage'])->name('bukuPage');
route::get('/DetailBuku', [LandingPageController::class, 'detailBuku'])->name('detailBuku');
