<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MateriController;




Route::get('/', [FrontendController::class, 'index'])->name('fe.index');
Route::get('/materi', [MateriController::class, 'index'])->name('materi.index');
Route::get('/materi/{id}', [MateriController::class, 'show'])->name('materi.detail');
Route::get('/video', [FrontendController::class, 'video'])->name('fe.video');
Route::get('/latihan', [FrontendController::class, 'latihan'])->name('fe.latihan');
Route::get('/latihan/mulai', [FrontendController::class, 'mulaiLatihan'])->name('latihan.mulai');
Route::post('/latihan/jawab', [FrontendController::class, 'simpanJawaban'])->name('latihan.jawab');
Route::post('/latihan/selesai', [FrontendController::class, 'selesaiLatihan'])->name('latihan.selesai');
Route::get('/latihan/hasil/{sesiLatihan}', [FrontendController::class, 'hasilLatihan'])->name('latihan.hasil');
Route::get('/nilai', [FrontendController::class, 'nilai'])->name('fe.nilai');
Route::get('/nilai/{latihan}', [FrontendController::class, 'detailNilai'])->name('fe.nilai.detail');


// Route::get('/', function () {
//     return view('welcome');
// });
