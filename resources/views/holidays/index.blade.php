@extends("layouts.master")

@section("title")
{{ __("project.Holiday List") }}
@endsection

@section("css")
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    color: #333;
  }

  .card {
    background: #fff;
    padding: 20px;
  }

  .card-header {
    padding: 20px;
    background: #f0f4f8;
    color: #333;
    font-size: 22px;
    font-weight: 700;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .card-body {
    padding: 30px;
  }

  .table th, .table td {
    padding: 15px;
    text-align: center;
    font-size: 14px;
    font-weight: 500;
  }

  .table-hover tbody tr:hover {
    background-color: #e3f2fd;
  }

  .table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9fbff;
  }

  .thead-custom th {
    background: #1da1f2;
    color: #fff;
    font-weight: 600;
  }

  .action-icons {
    display: flex;
    justify-content: space-around;
    gap: 15px;
  }

  .action-icon {
    font-size: 18px;
    transition: color 0.3s ease;
    position: relative;
    display: inline-block;
  }

  .action-icon.edit {
    color: #f1c40f; /* Soft yellow */
  }

  .action-icon.edit:hover {
    color: #f39c12; /* Brighter yellow on hover */
  }

  .action-icon.copy {
    color: #2ecc71; /* Soft green */
  }

  .action-icon.copy:hover {
    color: #27ae60; /* Brighter green on hover */
  }

  .action-icon.delete {
    color: #e74c3c; /* Soft red */
  }

  .action-icon.delete:hover {
    color: #c0392b; /* Brighter red on hover */
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
    color: #1da1f2;
    border: none;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .pagination .page-link:hover {
    background-color: #1da1f2;
    color: #fff;
  }

  .pagination .active .page-link {
    background-color: #1da1f2;
    color: #fff;
  }

  /* Modal Styling */
  .modal-dialog {
    max-width: 600px;
    margin: auto; /* Center the modal horizontally */
  }

  .modal-content {
    border-radius: 8px;
  }
  
  .modal-header {
    background-color: #f0f4f8;
    border-bottom: 1px solid #ddd;
  }

  .modal-body {
    background-color: #fff;
    padding: 30px;
  }

  .form-control {
    border-radius: 8px;
    font-size: 16px;
  }

  .modal-footer {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    background-color: #f9f9f9;
  }

  .btn-primary {
    background-color: #1da1f2;
    border-color: #1da1f2;
  }

  .btn-primary:hover {
    background-color: #007bff;
    border-color: #007bff;
  }
</style>
<link rel="stylesheet" href="{{ asset('app-assets/css/tablestyle.css') }}">
@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row"></div>
    <div class="content-body">
      <section id="holiday-list">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0">
                  <i class="fas fa-calendar-alt mr-2"></i>{{ __("Holiday List") }}
                </h4>
                <div>
                  <a href="{{ route('holiday.report') }}" class="btn btn-info mr-2" data-toggle="tooltip" title="View Holiday Report">
                    <i class="fas fa-file-alt"></i>
                  </a>
                  <!-- Calendar Popup Button -->
<button type="button" class="btn btn-outline-primary mr-2" data-toggle="modal" data-target="#calendarPopupModal" title="Show Calendar">
  <i class="fas fa-calendar-alt"></i>
</button>

                  <!-- Trigger button for the modal -->
                  <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addHolidayModal">
                    <i class="fas fa-plus"></i> {{ __('Add New Holiday') }}
                  </button>
                </div>
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

                  <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="{{ __('Search Holidays') }}">
                  </div>

                  <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                      <thead class="thead-custom">
                        <tr>
                          <th>ID</th>
                          <th>Occasion</th>
                          <th>Date</th>
                          <th>Created At</th>
                          <th>Updated At</th>
                          <th style="width: 20%;">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($holidays as $holiday)
                          <tr>
                            <td>{{ $holiday->id }}</td>
                            <td>{{ $holiday->occation }}</td>
                            <td>{{ \Carbon\Carbon::parse($holiday->date)->format('Y-m-d') }}</td>
                            <td>{{ $holiday->created_at ? $holiday->created_at->format('Y-m-d') : 'NULL' }}</td>
                            <td>{{ $holiday->updated_at ? $holiday->updated_at->format('Y-m-d') : 'NULL' }}</td>
                            <td>
                              <div class="action-icons">
                                <a href="javascript:void(0);" class="action-icon edit" title="Edit" data-toggle="modal" data-target="#editHolidayModal"
                                   data-id="{{ $holiday->id }}" data-occasion="{{ $holiday->occation }}" data-date="{{ \Carbon\Carbon::parse($holiday->date)->format('Y-m-d') }}">
                                  <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('holiday.copy', $holiday) }}" class="action-icon copy" title="Copy">
                                  <i class="fas fa-copy"></i>
                                </a>
                                <form action="{{ route('holiday.destroy', $holiday) }}" method="POST" class="delete-form d-inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="action-icon delete" title="Delete" style="border: none; background: none;">
                                    <i class="fas fa-trash-alt"></i>
                                  </button>
                                </form>
                              </div>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="6" class="text-center">{{ __("No holidays found") }}</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>

                  <div class="pagination">
                    {{ $holidays->links('pagination::bootstrap-4') }}
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

<!-- Calendar Popup Modal -->
<div class="modal fade" id="calendarPopupModal" tabindex="-1" role="dialog" aria-labelledby="calendarPopupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="calendarPopupModalLabel">Holiday Calendar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="calendarPicker" class="form-control" placeholder="Pick a date">
      </div>
    </div>
  </div>
</div>


<!-- Add Holiday Modal -->
<div class="modal fade" id="addHolidayModal" tabindex="-1" role="dialog" aria-labelledby="addHolidayModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addHolidayModalLabel">{{ __("Add Holiday") }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('holiday.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="occation" class="form-label"><i class="fas fa-flag mr-2"></i>{{ __("Occation") }}</label>
            <input type="text" class="form-control" id="occation" name="occation" required>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label"><i class="fas fa-calendar-alt mr-2"></i>{{ __("Date") }}</label>
            <input type="date" class="form-control" id="date" name="date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
          <button type="submit" class="btn btn-primary">{{ __("Add Holiday") }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Holiday Modal -->
<div class="modal fade" id="editHolidayModal" tabindex="-1" role="dialog" aria-labelledby="editHolidayModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="editHolidayForm" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editHolidayModalLabel">{{ __("Edit Holiday") }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editOccation" class="form-label"><i class="fas fa-flag mr-2"></i>{{ __("Occation") }}</label>
            <input type="text" class="form-control" id="editOccation" name="occation" required>
          </div>
          <div class="mb-3">
            <label for="editDate" class="form-label"><i class="fas fa-calendar-alt mr-2"></i>{{ __("Date") }}</label>
            <input type="date" class="form-control" id="editDate" name="date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
          <button type="submit" class="btn btn-primary">{{ __("Update Holiday") }}</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@section("js")
<!-- Flatpickr Styles & Script -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
  .holiday-highlight {
    background-color: #ffeb3b !important;
    color: #000 !important;
    border-radius: 50% !important;
    font-weight: bold;
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const holidays = @json($holidays->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d')));

    flatpickr("#calendarPicker", {
      inline: true,
      dateFormat: "Y-m-d",
      onDayCreate: function (dObj, dStr, fp, dayElem) {
        const date = dayElem.dateObj.toISOString().split('T')[0];
        if (holidays.includes(date)) {
          dayElem.classList.add("holiday-highlight");
        }
      }
    });
  });
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Delete confirmation
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
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            swalWithBootstrapButtons.fire({
              title: "Deleted!",
              text: "Your file has been deleted.",
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
              text: "Your file is safe :)",
              icon: "error"
            });
          }
        });
      });
    });
  });
</script>

<script>
  // Search filter functionality
  document.getElementById('search').addEventListener('keyup', function() {
    var query = this.value.toLowerCase();
    var rows = document.querySelectorAll('.table tbody tr');
    rows.forEach(function(row) {
      var occasion = row.cells[1].textContent.toLowerCase();
      row.style.display = occasion.indexOf(query) === -1 ? 'none' : '';
    });
  });

  // Edit modal population
  document.querySelectorAll('.action-icon.edit').forEach(button => {
    button.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      const occasion = this.getAttribute('data-occasion');
      const date = this.getAttribute('data-date');

      document.getElementById('editOccation').value = occasion;
      document.getElementById('editDate').value = date;

      // Update form action dynamically
      const form = document.getElementById('editHolidayForm');
      form.action = `/holidays/${id}`;
    });
  });

  
</script>

@endsection
