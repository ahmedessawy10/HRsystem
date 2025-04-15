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
              <!-- <div class="card-content collapse show">
                <div class="card-body">
                  @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif -->

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
                              <a href="{{ route('employees.show', $employee->id) }}" class="action-icon view" title="View">
                                <i class="la la-eye"></i>
                              </a>
                              <a href="{{ route('employees.edit', $employee->id) }}" class="action-icon edit" title="Edit">
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
  });
</script>
@endsection
