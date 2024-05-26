<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\RepairDetailsController;
use App\Http\Controllers\RepairSparePartController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout');
});

Route::resource('/clients', ClientController::class);
Route::resource('/vehicles', VehicleController::class);
Route::resource('/mechanics', MechanicController::class);
Route::resource('/spareparts', SparePartController::class);
Route::resource('/suppliers', SupplierController::class);
Route::resource('/repairs', RepairController::class);
Route::resource('/repair-details', RepairDetailsController::class);
Route::resource('/repair-spareparts', RepairSparePartController::class);
Route::resource('/invoices', InvoiceController::class);

Route::get('/register', UserController::class, 'create');