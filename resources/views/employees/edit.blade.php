@extends("layouts.master")
@section("title")
{{ __("app.edit employee") }}
@endsection
@section("css")
@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row"></div>
    <div class="content-body">
      <section id="basic-form-layouts">
        <div class="row match-height">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title" id="basic-layout-form">{{ __("app.edit employee") }}</h4>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="container mt-5">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                    @endif

                    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                      @csrf
                      @method('PUT')

                      <div class="row">
                        <div class="mb-3 col-md-6">
                          <label for="name" class="form-label">{{ __("app.name") }}</label>
                          <input type="text" class="form-control" id="name" name="name" required
                            value="{{ old('name', $employee->name) }}">
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="fullname" class="form-label">{{ __("app.full name") }}</label>
                          <input type="text" class="form-control" id="fullname" name="fullname"
                            value="{{ old('fullname', $employee->fullname) }}">
                        </div>
                      </div>

                      <div class="row">
                        <div class="mb-3 col-md-6">
                          <label for="email" class="form-label">{{ __("app.email") }}</label>
                          <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $employee->email) }}" required>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="phone" class="form-label">{{ __("app.phone") }}</label>
                          <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ old('phone', $employee->phone) }}">
                        </div>
                      </div>

                      <div class="row">
                        <div class="mb-3 col-md-6">
                          <label for="address" class="form-label">{{ __("app.address") }}</label>
                          <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address', $employee->address) }}" required>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="salary" class="form-label">{{ __("app.salary") }}</label>
                          <input type="number" class="form-control" id="salary" name="salary"
                            value="{{ old('salary', $employee->salary) }}">
                        </div>
                      </div>

                      <div class="row">
                        <div class="mb-3 col-md-6">
                          <label for="join_date" class="form-label">{{ __("app.join date") }}</label>
                          <input type="date" class="form-control" id="join_date" name="join_date"
                          value="{{ old('join_date', $employee->join_date ? \Carbon\Carbon::parse($employee->join_date)->toDateString() : '') }}"
                            required>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="nationality_id" class="form-label">{{ __("app.national id") }}</label>
                          <input type="text" class="form-control" id="nationality_id" name="nationality_id"
                            value="{{ old('nationality_id', $employee->nationality_id) }}">
                        </div>
                      </div>

                      <div class="row">
                        <div class="mb-3 col-md-6">
                          <label for="department" class="form-label">{{ __("app.department") }}</label>
                          <select class="form-control" id="department" name="department_id">
                            <option value="">{{ __("app.select") }}</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                              {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                              {{ $department->name }}
                            </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="job_position_id" class="form-label">{{ __("app.job position") }}</label>
                          <select class="form-control" id="job_position_id" name="job_position_id">
                            <option value="">{{ __("app.select") }}</option>
                            @foreach ($job_positions as $job_position)
                            <option value="{{ $job_position->id }}"
                              {{ old('job_position_id', $employee->job_position_id) == $job_position->id ? 'selected' : '' }}>
                              {{ $job_position->name }}
                            </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="mb-3 col-md-6">
                          <label for="gender" class="form-label">{{ __("app.gender") }}</label>
                          <select class="form-control" id="gender" name="gender">
                            <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>
                              {{ __("app.male") }}</option>
                            <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>
                              {{ __("app.female") }}</option>
                          </select>
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="birth_date" class="form-label">{{ __("app.birth date") }}</label>
                          <input type="date" class="form-control" id="birth_date" name="birthdate"
                          value="{{ old('birthdate', \Carbon\Carbon::parse($employee->birthdate)->toDateString()) }}"
                            required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="mb-3 col-md-6">
                          <label for="status" class="form-label">{{ __("app.status") }}</label>
                          <select class="form-control" id="status" name="status">
                            <option value="">{{ __('app.select') }}</option>
                            <option value="active" {{ old("status",$employee->status) == 'active' ? 'selected' : '' }}>
                              {{ __("app.active") }}</option>
                            <option value="inactive"
                              {{ old("status",$employee->status) == 'inactive' ? 'selected' : '' }}>
                              {{ __("app.inactive") }}</option>
                            <option value="pending"
                              {{ old("status",$employee->status) == 'pending' ? 'selected' : '' }}>
                              {{ __("app.pending") }}</option>
                            <option value="leave" {{ old("status",$employee->status) == 'leave' ? 'selected' : '' }}>
                              {{ __("app.leave") }}</option>
                          </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="mb-3 col-md-6">
                          <label for="start_time" class="form-label">{{ __("app.start time") }}</label>
                          <input type="time" class="form-control" id="start_time" name="start_time"
                            value="{{ old('start_time', $employee->start_time) }}">
                        </div>
                        <div class="mb-3 col-md-6">
                          <label for="end_time" class="form-label">{{ __("app.end time") }}</label>
                          <input type="time" class="form-control" id="end_time" name="end_time"
                            value="{{ old('end_time', $employee->end_time) }}">
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary">{{ __("app.save changes") }}</button>
                    </form>

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

@section("js")
@endsection