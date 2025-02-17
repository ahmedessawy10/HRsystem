<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\AttendanceController;

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::redirect('/', '/login', 301);
    Route::get('/formChangePass', [UserController::class, 'formChangePass'])->name('formChangePass');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('changePassword');



    Route::middleware(['auth', 'changepassword'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");

        // role and permission
        Route::resource('permission', PermissionController::class);
        Route::resource('userRole', UserRoleController::class);


        //salary pages
        Route::resource('salarys', SalaryController::class);
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::group(['middleware' => 'auth'], function() {
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/list', [AttendanceController::class, 'list'])->name('attendance.list');
    Route::get('/attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('/attendance/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
});






require __DIR__ . '/auth.php';
