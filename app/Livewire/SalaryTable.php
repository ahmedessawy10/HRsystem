<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\trait\SalaryCalc;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Spatie\Permission\Models\Role;

class SalaryTable extends Component
{
    use SalaryCalc, WithPagination;

    public $year;
    public $month;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['year', 'month'];

    protected function getListeners()
    {
        return ['refreshComponent' => '$refresh'];
    }

    public function mount()
    {
        $this->year = $this->year ?? Carbon::now()->year;
        $this->month = $this->month ?? Carbon::now()->subMonth()->month;
    }

    public function updatedYear()
    {
        $this->resetPage();
    }

    public function updatedMonth()
    {
        $this->resetPage();
    }

    public function render()
    {
        $startDate = Carbon::create($this->year, $this->month, 1)->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::create($this->year, $this->month, 1)->endOfMonth()->format('Y-m-d');

        try {
            $users = User::whereHas('roles', function ($query) {
                $query->where('id', 3);
            })
                ->with([
                    'attendances' => fn($query) => $query->whereBetween('date', [$startDate, $endDate]),
                    'department'
                ])
                ->select('id', 'fullname', 'salary', 'start_time', 'end_time', 'department_id')
                ->paginate(10);

            $attaneces_count_func = $this->calcDayMonth($this->year, $this->month);
            foreach ($users as $user) {
                $total_late = $user->attendances->sum('late_hours');
                $total_extra = $user->attendances->sum('extra_hours');
                $count_attendance = $user->attendances->count();

                // dd($attaneces_count_func);
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
                $user->total_deduction = round($calcSalary['total_deduction'], 2);
                $user->total_increase = round($calcSalary['total_increase'], 2);
                $user->total_work_minutes_cost = $calcSalary['total_work_hours_cost'];
                $user->netSalary = $calcSalary['net_salary'];
            }




            return view('livewire.salary-table', ['users' => $users]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while loading the data.');
            return view('livewire.salary-table', ['users' => collect()]);
        }
    }
}
