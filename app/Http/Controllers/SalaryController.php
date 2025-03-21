<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Salary;
use App\Models\Company;
use App\Models\Holiday;
use App\Models\HrSetting;
use App\trait\SalaryCalc;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;

class SalaryController extends Controller
{
    use SalaryCalc;
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        return view('salary.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function print(Salary $salary)
    {

        $company = Company::first();


        $username = $salary->user->fullname;
        $filename = $username . '-salary-' . $salary->year . '-' . $salary->month . '.pdf';


        // return  view('pdf.salaries', compact('salary', 'company'));

        $pdf = Pdf::loadView('pdf.salaries', compact('salary', 'company'));
        return $pdf->download($filename);
        // return response($pdf->output(), 200)->header('Content-Type', 'application/pdf');
    }
}
