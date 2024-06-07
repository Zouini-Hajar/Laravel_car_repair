<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\RepairDetailsController;
use App\Http\Controllers\RepairRequestController;
use App\Http\Controllers\RepairSparePartController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Models\Client;
use App\Models\Mechanic;
use App\Models\Repair;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/clients/search', [ClientController::class, 'search']);
    Route::resource('/clients', ClientController::class);
    Route::get('/clients-export', [ClientController::class, 'export']);
    Route::post('/clients-import', [ClientController::class, 'import']);

    Route::get('/vehicles/search', [VehicleController::class, 'search']);
    Route::resource('/vehicles', VehicleController::class);
    Route::get('/vehicles-export', [VehicleController::class, 'export']);
    Route::post('/vehicles-import', [VehicleController::class, 'import']);

    Route::get('/mechanics/search', [MechanicController::class, 'search']);
    Route::resource('/mechanics', MechanicController::class);
    Route::get('/mechanics-export', [MechanicController::class, 'export']);
    Route::post('/mechanics-import', [MechanicController::class, 'import']);

    Route::resource('/spareparts', SparePartController::class);
    Route::get('/spareparts-export', [SparePartController::class, 'export']);
    Route::post('/spareparts-import', [SparePartController::class, 'import']);

    Route::resource('/suppliers', SupplierController::class);
    Route::get('/suppliers-export', [SupplierController::class, 'export']);
    Route::post('/suppliers-import', [SupplierController::class, 'import']);

    Route::get('/', function () {
        if (auth()->user()->role == 'admin') {
            return view('dashboard', [
                'clients' => Client::count(),
                'mechanics' => Mechanic::count(),
                'repairs' => Repair::count(),
                'vehicles' => Vehicle::count(),
            ]);
        } elseif (auth()->user()->role == 'client' || auth()->user()->role == 'mechanic') {
            return redirect('/vehicles');
        }
    });

    Route::resource('/repairs', RepairController::class);
    Route::resource('/repair-details', RepairDetailsController::class);
    Route::resource('/repair-spareparts', RepairSparePartController::class);
    Route::resource('/invoices', InvoiceController::class);
    Route::resource('/meetings', MeetingController::class);
    Route::post('/logout', [UserController::class, 'logout']);
});


// Pdf
Route::get('generate-pdf/{id}', [PDFController::class, 'generatePDF']);


// Repair Request
Route::post('/request-repair', [RepairRequestController::class, 'submit']);
Route::get('/confirm-repair', [RepairRequestController::class, 'confirm']);
Route::get('/reject-repair', [RepairRequestController::class, 'reject']);


// Auth
Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [UserController::class, 'create']);
    Route::post('/register', [UserController::class, 'store']);
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'authenticate']);
});


// Email Verification
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


// Reset Password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])->with('success', 'Link sent successfully !')
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
