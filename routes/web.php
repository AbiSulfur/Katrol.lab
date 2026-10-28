<?php

use App\Http\Controllers\KatrolController;
use Illuminate\Support\Facades\Route;

// Halaman Beranda (Landing Page) & Simulator
Route::get('/', [KatrolController::class, 'index'])->name('simulator.index');
Route::get('/home', [KatrolController::class, 'home'])->name('home');
Route::get('/simulator', [KatrolController::class, 'index'])->name('simulator.view');
Route::get('/profil', [KatrolController::class, 'profil'])->name('profil.index');

// API Endpoints
Route::post('/api/profil/simpan', [KatrolController::class, 'simpanProfil'])->name('api.profil.simpan');
Route::post('/api/siswa/simpan', [KatrolController::class, 'simpanSiswa'])->name('api.siswa.simpan');
Route::post('/api/siswa/reset', [KatrolController::class, 'resetSiswa'])->name('api.siswa.reset');
Route::post('/api/simulasi/simpan', [KatrolController::class, 'simpanSimulasi'])->name('api.simulasi.simpan');
Route::post('/api/ekspor-csv', [KatrolController::class, 'eksporCSV'])->name('api.ekspor.csv');
