@extends("layouts.master")
@section("title", __("project.employee_list"))

@section("css")
<style>
  .thead-custom th {
    background: #1da1f2;
    color: #fff;
    font-weight: 600;
  }

  .action-icons {
    display: flex;
    justify-content: center;
    gap: 12px;
  }

  .action-icon {
    display: inline-block;
    font-size: 18px;
    cursor: pointer;
    color: #6c757d;
    background: none;
    border: none;
    transition: color 0.3s ease;
  }

  .action-icon.view {
    color: #007bff;
  }

  .action-icon.edit {
    color: #ffc107;
  }

  .action-icon.delete {
    color: #dc3545;
  }

  .action-icon:hover {
    opacity: 0.8;
    transform: scale(1.1);
  }

  .pagination {
    justify-content: center;
    margin-top: 20px;
  }

  .pagination .page-link {
    border-radius: 50px;
    padding: 8px 16px;
    margin: 0 5px;
    background-color: #e9ecef;
    color: #007bff;
    border: none;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .pagination .page-link:hover {
    background-color: #007bff;
    color: #fff;
  }

  .pagination .active .page-link {
    background-color: #007bff;
    color: #fff;
  }
</style>

<link rel="stylesheet" href="{{ asset('app-assets/css/tablestyle.css') }}">
@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-body">
      <section id="basic-form-layouts">
        <div class="row match-height">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __("Employee List") }}</h4>
                <a href="{{ route('employees.create') }}" class="btn btn-primary">
                  <i class="la la-plus"></i> Add New Employee
                </a>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif

                  <input type="text" id="search" class="form-control mb-3" placeholder="{{ __('Search Employee') }}">

                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead class="thead-custom">
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
                            <div class="action-icons">
                              <a href="javascript:void(0);" class="action-icon view" title="View" data-toggle="modal" data-target="#employeeDetailsModal" data-id="{{ $employee->id }}" data-name="{{ $employee->name }}" data-email="{{ $employee->email }}" data-phone="{{ $employee->phone }}" data-salary="{{ $employee->salary }}" data-join_date="{{ $employee->join_date }}" data-nationality_id="{{ $employee->nationality_id }}" data-role="{{ $employee->role }}" data-gender="{{ $employee->gender }}">
                                <i class="la la-eye"></i>
                              </a>
                              <a href="javascript:void(0);" class="action-icon edit" title="Edit" data-toggle="modal" data-target="#employeeEditModal" data-id="{{ $employee->id }}" data-name="{{ $employee->name }}" data-email="{{ $employee->email }}" data-phone="{{ $employee->phone }}" data-salary="{{ $employee->salary }}" data-join_date="{{ $employee->join_date }}" data-nationality_id="{{ $employee->nationality_id }}" data-role="{{ $employee->role }}" data-gender="{{ $employee->gender }}">
                                <i class="la la-edit"></i>
                              </a>
                              <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-icon delete" title="Delete">
                                  <i class="la la-trash"></i>
                                </button>
                              </form>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>

                  {{ $employees->links('pagination::bootstrap-4') }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<!-- Modal for Employee Details -->
<div class="modal fade" id="employeeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="employeeDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="employeeDetailsModalLabel">Employee Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>ID:</strong> <span id="employeeId"></span></p>
        <p><strong>Name:</strong> <span id="employeeName"></span></p>
        <p><strong>Full Name:</strong> <span id="employeeFullName"></span></p>
        <p><strong>Email:</strong> <span id="employeeEmail"></span></p>
        <p><strong>Phone:</strong> <span id="employeePhone"></span></p>
        <p><strong>Salary:</strong> <span id="employeeSalary"></span></p>
        <p><strong>Join Date:</strong> <span id="employeeJoinDate"></span></p>
        <p><strong>National ID:</strong> <span id="employeeNationalityId"></span></p>
        <p><strong>Role:</strong> <span id="employeeRole"></span></p>
        <p><strong>Gender:</strong> <span id="employeeGender"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Employee Edit -->
<div class="modal fade" id="employeeEditModal" tabindex="-1" role="dialog" aria-labelledby="employeeEditModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="employeeEditModalLabel">Edit Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('employees.update', ':id') }}" method="POST" id="editEmployeeForm">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <input type="hidden" id="editEmployeeId" name="id">

          <div class="form-group">
            <label for="editName">Name</label>
            <input type="text" class="form-control" id="editName" name="name" required>
          </div>

          <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
          </div>

          <div class="form-group">
            <label for="editPhone">Phone</label>
            <input type="text" class="form-control" id="editPhone" name="phone" required>
          </div>

          <div class="form-group">
            <label for="editSalary">Salary</label>
            <input type="number" class="form-control" id="editSalary" name="salary" required>
          </div>

          <div class="form-group">
            <label for="editJoinDate">Join Date</label>
            <input type="date" class="form-control" id="editJoinDate" name="join_date" required>
          </div>

          <div class="form-group">
            <label for="editRole">Role</label>
            <input type="text" class="form-control" id="editRole" name="role" required>
          </div>

          <div class="form-group">
            <label for="editGender">Gender</label>
            <select class="form-control" id="editGender" name="gender" required>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section("js")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // SweetAlert Delete Confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
          },
          buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
          title: "Are you sure?",
          text: "This action cannot be undone!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({
              title: "Deleted!",
              text: "Employee has been deleted.",
              icon: "success",
              showConfirmButton: false,
              timer: 1300
            });
            setTimeout(() => {
              e.target.submit();
            }, 1300);
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
              title: "Cancelled",
              text: "Employee is safe :)",
              icon: "error"
            });
          }
        });
      });
    });

    // Client-side search filter
    document.getElementById('search').addEventListener('keyup', function () {
      var query = this.value.toLowerCase();
      var rows = document.querySelectorAll('.table tbody tr');
      rows.forEach(function (row) {
        var name = row.cells[1].textContent.toLowerCase();
        row.style.display = name.indexOf(query) === -1 ? 'none' : '';
      });
    });

    // Set employee details when View icon is clicked
    $('#employeeDetailsModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var name = button.data('name');
      var email = button.data('email');
      var phone = button.data('phone');
      var salary = button.data('salary');
      var joinDate = button.data('join_date');
      var nationalityId = button.data('nationality_id');
      var role = button.data('role');
      var gender = button.data('gender');

      $('#employeeId').text(id);
      $('#employeeName').text(name);
      $('#employeeFullName').text(name); // You may use the full name if available
      $('#employeeEmail').text(email);
      $('#employeePhone').text(phone);
      $('#employeeSalary').text(salary);
      $('#employeeJoinDate').text(joinDate);
      $('#employeeNationalityId').text(nationalityId);
      $('#employeeRole').text(role);
      $('#employeeGender').text(gender);
    });

    // Set employee data to Edit modal
    $('#employeeEditModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var name = button.data('name');
      var email = button.data('email');
      var phone = button.data('phone');
      var salary = button.data('salary');
      var joinDate = button.data('join_date');
      var nationalityId = button.data('nationality_id');
      var role = button.data('role');
      var gender = button.data('gender');

      $('#editEmployeeId').val(id);
      $('#editName').val(name);
      $('#editEmail').val(email);
      $('#editPhone').val(phone);
      $('#editSalary').val(salary);
      $('#editJoinDate').val(joinDate);
      $('#editRole').val(role);
      $('#editGender').val(gender);
      $('#editEmployeeForm').attr('action', '/employees/' + id);
    });
  });
</script>
@endsection
