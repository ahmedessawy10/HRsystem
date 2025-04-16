<?php

use Livewire\Livewire;
use App\Livewire\Counter;
use App\Models\HrSetting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HrSettingController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\CvController;

use App\Http\Controllers\AttendanceController;

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\JobpositionController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\HolidayController; // For holidays
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\AttendanceHomeController; // For attendance
use App\Http\Controllers\CvAnalysisController; // For CV Analysis

use App\Http\Controllers\HomeController;

Route::get("/", [HomeController::class, "home"])->name("home");
Route::get("/home/careers", [HomeController::class, "careers"])->name("home.careers");
Route::get("/home/careers/{career}", [HomeController::class, "showCareer"])->name("home.career.details");
Route::post("/home/careers/{career}/apply", [HomeController::class, "applyCareer"])->name("home.career.apply");
Route::get("/notify", [HomeController::class, "notify"]);

// Route::redirect('/', '/home', 301);



Route::group(['prefix' => LaravelLocalization::setLocale()], function () {



    // **livewire for localiztion
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle);
    });


    Route::get('/formChangePass', [UserController::class, 'formChangePass'])->name('formChangePass');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
    Route::get('/counter', function () {
        return view('test');
    });
    Route::middleware(['auth', 'changepassword'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");


        //** Role and Permission routes
        Route::resource('permission', PermissionController::class);
        Route::resource('userRole', UserRoleController::class);

        //**salary pages
        Route::resource('salaries', SalaryController::class);
        Route::get('salaries/{salary}/print', [SalaryController::class, 'print'])->name('salaries.print');
        // **Holiday routes
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

        // **Attendance routes (for employee attendance)
        Route::prefix('attendance-home')->name('attendanceHome.')->group(function () {
            Route::get('/', [AttendanceHomeController::class, 'index'])->name('index');
            Route::post('/checkin', [AttendanceHomeController::class, 'checkIn'])->name('checkin');
            Route::post('/checkout', [AttendanceHomeController::class, 'checkOut'])->name('checkout');
        });
        // **attendance
        Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/list', [AttendanceController::class, 'list'])->name('attendance.list');
        Route::get('/attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('/attendance/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');


        // ** employee
        Route::resource('employees', EmployeeController::class);



        //&& app 

        //** departments  */
        Route::resource('departments', DepartmentController::class);
        //** jobposition  */
        Route::resource('jobpositions', JobpositionController::class);
        //** hr setting   */
        Route::resource('hrSettings', HrSettingController::class)->only(['index', 'store']);
        Route::resource('appSettings', AppSettingController::class)->only(['index', 'store']);

        // ** company
        Route::resource("companySetting", CompanyController::class)->only(['index', "store"]);
        // ** careers
        Route::resource('/careers', CareerController::class);
        // ** chat app
        Route::post("/aichat", [ChatController::class, "ai_chat"]);
        Route::post("/chat", [ChatController::class, "ai_chat"]);
        Route::resource("/chats", ChatController::class);
        Route::get('/cv/upload', [CvAnalysisController::class, 'showUploadForm'])->name('cv.upload');
        Route::delete('cv-analysis/{cvAnalysis}', [CvAnalysisController::class, 'destroy'])->name('cv-analysis.destroy');

        // CV Management Routes
        Route::prefix('cvs')->name('cvs.')->group(function () {
            Route::get('/', [CvAnalysisController::class, 'index'])->name('index');
            Route::get('/upload', [CvAnalysisController::class, 'showUploadForm'])->name('upload-form');
            Route::post('/upload', [CvAnalysisController::class, 'store'])->name('store');
            Route::post('/analyze', [CvAnalysisController::class, 'analyze'])->name('analyze');
            Route::delete('/{cvAnalysis}', [CvAnalysisController::class, 'destroy'])->name('destroy');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

Route::middleware(['auth', 'changepassword'])->group(function () {
    // CV Analysis routes
    Route::get('/cv/upload', [CvAnalysisController::class, 'showUploadForm'])->name('cv.upload');
    Route::post('/cv/upload', [CvAnalysisController::class, 'store'])->name('cv.store');
    Route::post('/cv/analyze', [CvAnalysisController::class, 'analyze'])->name('cv.analyze');
    Route::resource('cv-analysis', CvAnalysisController::class);
    Route::delete('cv-analysis/{cvAnalysis}', [CvAnalysisController::class, 'destroy'])->name('cv-analysis.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('cvs', CvController::class);
    // This will create all RESTful routes including:
    // GET /cvs (index)
    // POST /cvs (store)
    // DELETE /cvs/{cv} (destroy)
    Route::delete('/cvs/{cv}', [CvController::class, 'destroy'])->name('cvs.destroy');
});

require __DIR__ . '/auth.php';
