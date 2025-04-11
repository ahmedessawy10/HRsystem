<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\AppSetting;
use App\Models\Attendance;
use App\Events\Notifications;
use App\Observers\AttendObserver;
use App\Listeners\NotificationsSend;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Attendance::observe(AttendObserver::class);
        Paginator::useBootstrapFive();
        $appSetting = AppSetting::find(1);
        $companyInfo = Company::find(1);
        View::share('appSetting', $appSetting);
        View::share('companyInfo',  $companyInfo);


        Event::listen(
            Notifications::class,
            NotificationsSend::class,
        );
    }
}
