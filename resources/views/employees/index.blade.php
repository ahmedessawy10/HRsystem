@extends("layouts.master")
@section("title", __("project.employee_list"))

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-body">
      <section id="basic-form-layouts">
        <div class="row match-height">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{ __("Employee List") }}</h4>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="container mt-4">
                    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">
                      <i class="la la-plus"></i> Add New Employee
                    </a>
                    <table class="table table-striped">
                      <thead class="thead-dark">
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($employees as $employee)
                          <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>
                              <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info btn-sm">
                                <i class="la la-eye"></i> View
                              </a>
                              <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">
                                <i class="la la-edit"></i> Edit
                              </a>
                              <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                  <i class="la la-trash"></i> Delete
                                </button>
                              </form>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
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
