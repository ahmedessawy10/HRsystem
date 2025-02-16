<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EmployeeController;

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::redirect('/', '/login', 301);
    Route::get('/formChangePass', [UserController::class, 'formChangePass'])->name('formChangePass');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('changePassword');



    Route::middleware(['auth', 'changepassword'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");

        // role and permission
        Route::resource('permission', PermissionController::class);
        Route::resource('userRole', UserRoleController::class);
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

// Route to display a single employee
// Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
// Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
// Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
// Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
// Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
// Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::resource('employees', EmployeeController::class);

require __DIR__ . '/auth.php';
