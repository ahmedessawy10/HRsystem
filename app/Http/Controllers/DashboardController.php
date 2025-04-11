<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Career;
use App\Models\Salary;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $holiday = Holiday::whereDate('date', now())->first();

        $statistics = [
            'employee_count' => 0,
            "total_payroll" => 0,
            "open_career_count" => 0,
            'holiday' => $holiday,
        ];

        if ($user->can('statistics employee_count')) {
            $employeeCount =  User::role("employee")->count();
            $statistics['employee_count'] =  $employeeCount;
        }
        if ($user->can('statistics total_payroll')) {
            $now = Carbon::now()->subMonth();
            $totalPayroll = Salary::where('month', $now->month)
                ->where('year', $now->year)
                ->sum('net_salary');
            $statistics['total_payroll'] = $totalPayroll;
        }
        if ($user->can('statistics open_career_count')) {
            $open_career_count = Career::where('status', "open")->count();
            $statistics['open_career_count'] = $open_career_count;
        }


        return view('home', $statistics);
    }
}
