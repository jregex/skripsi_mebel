<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\InvoiceController;
use App\Invoice;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);


Route::middleware('auth')->group(function () {

    Route::get('/logout', [LoginController::class, 'logout']);

    Route::get('/', [BarangController::class, 'index']);
    Route::post('/', [BarangController::class, 'store']);

    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::post('/invoice', [InvoiceController::class, 'storePenjualan']);
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice/create', [InvoiceController::class, 'store']);
    Route::patch('/invoice/update', [InvoiceController::class, 'updateJumlahPembelian']);
    Route::get('/invoice/pdf/{invoice}',[InvoiceController::class, 'showPdf']);
    Route::delete('/invoice/{invoice}',[InvoiceController::class,'destroy'])->name('invoice.delete');

    Route::get('/delivery-order', [DeliveryOrderController::class, 'index'])->name('deliveryorder.index');
    Route::post('/delivery-order', [DeliveryOrderController::class, 'storeDeliveryOrder']);
    Route::get('/delivery-order/create', [DeliveryOrderController::class, 'create'])->name('deliveryorder.create');
    Route::post('/delivery-order/create', [DeliveryOrderController::class, 'store']);
    Route::delete('/delivery-order/{id}', [DeliveryOrderController::class, 'delete'])->name('deliveryorder.delete');
    Route::patch('/delivery-order/update', [DeliveryOrderController::class, 'updateJumlahPembelian']);
    Route::get('/delivery-order/pdf/{delivery_order}',[DeliveryOrderController::class, 'showPdf']);
});
