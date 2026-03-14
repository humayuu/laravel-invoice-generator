<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;


Route::get('/', [InvoiceController::class, 'index']);
Route::get('invoice/pdf/{id}', [InvoiceController::class, 'generateInvoicePDF'])->name('invoice.pdf');
Route::resource('invoice', InvoiceController::class);