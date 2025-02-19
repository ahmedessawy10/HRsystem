<?php

use App\Livewire\Counter;
use App\Models\HrSetting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HrSettingController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\JobpositionController;
use App\Http\Controllers\HolidayController; // For holidays

use App\Http\Controllers\EmployeeController;

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\AttendanceHomeController; // For attendance

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Route::redirect('/', '/login', 301);
    Route::get('/formChangePass', [UserController::class, 'formChangePass'])->name('formChangePass');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('changePassword');

    Route::middleware(['auth', 'changepassword'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");

        Route::get('/counter', Counter::class);
        // Role and Permission routes
        Route::resource('permission', PermissionController::class);
        Route::resource('userRole', UserRoleController::class);

        //salary pages
        Route::resource('salarys', SalaryController::class);
        // Holiday routes
        Route::prefix('holidays')->name('holiday.')->group(function () {
            Route::get('/', [HolidayController::class, 'index'])->name('index');
            Route::get('/create', [HolidayController::class, 'create'])->name('create');
            Route::post('/', [HolidayController::class, 'store'])->name('store');
            Route::get('/{holiday}/edit', [HolidayController::class, 'edit'])->name('edit');
            Route::put('/{holiday}', [HolidayController::class, 'update'])->name('update');
            Route::delete('/{holiday}', [HolidayController::class, 'destroy'])->name('destroy');
            Route::get('/{holiday}/copy', [HolidayController::class, 'copy'])->name('copy');
            Route::get('/calendar', [HolidayController::class, 'calendar'])->name('calendar');
            Route::get('/report', [HolidayController::class, 'report'])->name('report');
        });

        // Attendance routes (for employee attendance)
        Route::prefix('attendance-home')->name('attendanceHome.')->group(function () {
            Route::get('/', [AttendanceHomeController::class, 'index'])->name('index');
            Route::post('/checkin', [AttendanceHomeController::class, 'checkIn'])->name('checkin');
            Route::post('/checkout', [AttendanceHomeController::class, 'checkOut'])->name('checkout');
        });
        // attendance
        Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/list', [AttendanceController::class, 'list'])->name('attendance.list');
        Route::get('/attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('/attendance/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');




        // app 

        //** departments  */
        Route::resource('departments', DepartmentController::class);
        //** jobposition  */
        Route::resource('jobpositions', JobpositionController::class);
        //** hr setting   */
        Route::resource('hrSettings', HrSettingController::class)->only(['index', 'store']);
        Route::resource('appSettings', AppSettingController::class)->only(['index', 'store']);
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
