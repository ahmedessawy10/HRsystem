<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\trait\SalaryCalc;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class SalaryTable extends Component
{
    use SalaryCalc;

    public $year;
    public $month;

    public function mount()
    {

        $this->year = Carbon::now()->year;
        $this->month = Carbon::now()->subMonth()->month;
    }

    public function render()
    {
        $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth()->format('Y-m-d');
        $users = User::whereHas('roles', function ($query) {
            $query->where('id', 3);
        })
            ->with([
                'attendances' => fn($query)  => $query->whereBetween('date', [$startDate, $endDate]),
                'department'
            ])
            ->select('id', 'fullname', 'salary', 'start_time', 'end_time', 'department_id')
            ->paginate(10);

        foreach ($users as $user) {
            $total_late = $user->attendances->sum('late_minutes');
            $total_extra = $user->attendances->sum('extra_minutes');
            $count_attendance = $user->attendances->count();
            $attaneces_count_func =  $this->calcDayMonth($this->year, $this->month);
            $calcSalary = $this->calcSalary(
                $user->salary,
                $total_late,
                $total_extra,
                $attaneces_count_func,
                $user->start_time,
                $user->end_time
            );
            $user->total_late = $total_late;
            $user->total_extra = $total_extra;
            $user->attendances_count = $count_attendance;
            $user->total_deduction = $calcSalary['total_deduction'];
            $user->total_increase = $calcSalary['total_increase'];
            $user->total_work_minutes_cost = $calcSalary['total_work_minutes_cost'];
            $user->netSalary = $calcSalary['net_salary'];
        }

        return view('livewire.salary-table', compact('users'));
    }
}
