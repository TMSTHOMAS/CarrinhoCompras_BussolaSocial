<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompraController;

Route::get('/', [CompraController::class, 'index'])->name('compra.index');
Route::post('/processar', [CompraController::class, 'processarCompra'])->name('compra.processar');
