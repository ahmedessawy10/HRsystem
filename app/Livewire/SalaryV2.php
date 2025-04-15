<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\HrSetting;
use App\Trait\SalaryCalc;
use Livewire\WithPagination;

class SalaryV2 extends Component
{
    use WithPagination, SalaryCalc;
    public $year;
    public $month;
    public $paginationTheme = 'bootstrap';
    public  $queryString = ['year', 'month'];
    public $user;
    public $attendances_count;

    public function mount()
    {
        $this->year = Carbon::now()->year;
        $this->month = Carbon::now()->subMonth()->month;
        $this->attendances_count = $this->calcDayMonth(
            $this->year,
            $this->month,
            json_decode(HrSetting::first()->holidays)
        );
    }
    public function render()
    {
        $users = User::role("employee")->select(['fullname', 'id', 'department_id'])->when($this->user, function ($query) {
            $query->where('fullname', 'like', '%' . $this->user . '%');
        })
            ->whereHas('salaries', function ($query) {
                $query->where('year', $this->year)
                    ->where('month', $this->month);
            })
            ->with(['salaries' => function ($query) {
                $query->where('year', $this->year)
                    ->where('month', $this->month);
            }, 'department'])

            ->paginate(10);

        $this->attendances_count = $this->calcDayMonth(
            $this->year,
            $this->month,
            json_decode(HrSetting::first()->holidays)
        );

        // dd($this->user);
        // $this->user = null;


        return view('livewire.salary-v2', compact('users'));
    }
}
