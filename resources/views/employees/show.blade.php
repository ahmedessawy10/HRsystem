@extends("layouts.master")
@section("title", __("project.employee_details"))

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-body">
      <section id="basic-form-layouts">
        <div class="row match-height">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{ __("Employee Details") }}</h4>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="container mt-4">
                    <div class="card">
                      <div class="card-body">
                        <p><strong>ID:</strong> {{ $employee->id }}</p>
                        <p><strong>Name:</strong> {{ $employee->name }}</p>
                        <p><strong>Full Name:</strong> {{ $employee->fullname }}</p>
                        <p><strong>Email:</strong> {{ $employee->email }}</p>
                        <p><strong>Phone:</strong> {{ $employee->phone }}</p>
                        <p><strong>Salary:</strong> {{ $employee->salary }}</p>
                        <p><strong>Join Date:</strong> {{ $employee->join_date }}</p>
                        <p><strong>National ID:</strong> {{ $employee->nationality_id }}</p>
                        <p><strong>Role:</strong> {{ $employee->role }}</p>
                        <p><strong>Gender:</strong> {{ $employee->gender }}</p>
                      </div>
                    </div>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary mt-3">
                      <i class="la la-arrow-left"></i> Back to List
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection
