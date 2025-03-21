<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class SalaryV2 extends Component
{
    use WithPagination;
    public $year;
    public $month;
    public $paginationTheme = 'bootstrap';
    public  $queryString = ['year', 'month'];
    public $user;

    public function mount()
    {
        $this->year = Carbon::now()->year;
        $this->month = Carbon::now()->subMonth()->month;
    }
    public function render()
    {
        $users = User::select(['fullname', 'id', 'department_id'])->when($this->user, function ($query) {
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
            ->withCount('attendances')
            ->paginate(10);

        // dd($this->user);
        // $this->user = null;


        return view('livewire.salary-v2', compact('users'));
    }
}
