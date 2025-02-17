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

require __DIR__ . '/auth.php';
