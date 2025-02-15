<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HRSettingsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\JobPositionController;

Route::get('/employees/{department_id}', [JobPositionController::class, 'getEmployeesByDepartment']);

Route::get('/job_positions/employees', [JobPositionController::class, 'getEmployeesByDepartment'])->name('job_positions.getEmployees');
Route::post('/job_positions/update', [JobPositionController::class, 'updateJobPosition'])->name('job_positions.updateJobPosition');
Route::post('/job_positions/delete', [JobPositionController::class, 'deleteJobPosition'])->name('job_positions.deleteJobPosition');

Route::resource('departments', DepartmentController::class)->except(['create', 'edit', 'show']);
Route::resource('job_positions', JobPositionController::class)->except(['create', 'edit', 'show']);
Route::resource('departments', DepartmentController::class);
Route::resource('job_positions', JobPositionController::class);


Route::get('/hr-settings', [HRSettingsController::class, 'index'])->name('hr.settings');
Route::post('/hr-settings/update', [HRSettingsController::class, 'update'])->name('hr.settings.update');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::put('/settings/update', [SettingsController::class, 'update'])->name('settings.update');

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

require __DIR__ . '/auth.php';
