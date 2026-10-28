<?php

use App\Http\Controllers\KatrolController;
use Illuminate\Support\Facades\Route;

Route::get('/', [KatrolController::class, 'index'])->name('simulator.index');
Route::post('/api/siswa/simpan', [KatrolController::class, 'simpanSiswa'])->name('api.siswa.simpan');
Route::post('/api/siswa/reset', [KatrolController::class, 'resetSiswa'])->name('api.siswa.reset');
Route::post('/api/simulasi/simpan', [KatrolController::class, 'simpanSimulasi'])->name('api.simulasi.simpan');
Route::post('/api/ekspor-csv', [KatrolController::class, 'eksporCSV'])->name('api.ekspor.csv');
