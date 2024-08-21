<?php

use App\Http\Controllers\GenerateInvoicingController;
use App\Http\Controllers\InvoicingController;
use Illuminate\Support\Facades\Route;

Route::get('/generate-invoicing', GenerateInvoicingController::class);
Route::apiResource('/invoicing', InvoicingController::class);
