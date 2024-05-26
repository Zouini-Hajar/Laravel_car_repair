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
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified']], function () {
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
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [UserController::class, 'create']);
    Route::post('/register', [UserController::class, 'store']);
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'authenticate']);
});
