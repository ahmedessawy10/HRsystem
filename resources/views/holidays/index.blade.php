@extends("layouts.master")

@section("title")
{{ __("project.Holiday List") }}
@endsection

@section("css")
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f4f8;
    color: #333;
  }

  .card {
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    border: none;
  }

  .card:hover {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  }

  .card-header {
    padding: 20px;
    background: #f0f4f8;
    color: #fff;
    font-size: 22px;
    font-weight: 700;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .card-body {
    padding: 30px;
  }

  /* Table Styles */
  .table th,
  .table td {
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

  /* Search Input */
  #search {
    border-radius: 25px;
    padding: 12px 20px;
    font-size: 15px;
    border: 1px solid #ccc;
    background-color: #fff;
    width: 100%;
    margin-bottom: 20px;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  #search:focus {
    border-color: #1da1f2;
    box-shadow: 0 0 8px rgba(29, 161, 242, 0.3);
    outline: none;
  }

  /* Buttons & Actions */
  .btn-light {
    background-color: #1da1f2;
    color: #fff;
    border-radius: 8px;
    padding: 10px 16px;
    transition: background-color 0.3s ease;
  }

  .btn-light:hover {
    background-color: #007bff;
  }

  /* Dropdown Menu Styles */
  .dropdown .dropdown-toggle {
    background: transparent;
    border: none;
    color: #333;
    font-size: 18px;
    padding: 4px;
  }

  .dropdown .dropdown-toggle:focus {
    outline: none;
    box-shadow: none;
  }

  .dropdown-menu {
    min-width: 140px;
  }

  .dropdown-item {
    font-size: 14px;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .dropdown-item:hover {
    background: #1da1f2;
    color: #fff;
  }

  /* Pagination Styles */
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

  /* Alert Styles */

  @media (max-width: 767px) {
    .table-responsive {
      margin-bottom: 20px;
    }

    #search {
      width: 100%;
    }
  }
</style>
<link rel="stylesheet" href="{{ asset("app-assets/css/tablestyle.css") }}">
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
                  <a href="{{ route('holiday.report') }}" class="btn btn-info mr-2" data-toggle="tooltip"
                    data-placement="top" title="View Holiday Report">
                    <i class="fas fa-file-alt"></i>
                  </a>
                  <a href="{{ route('holiday.create') }}" class="btn btn-light" data-toggle="tooltip"
                    data-placement="top" title="{{ __('Add New Holiday') }}">
                    <i class="fas fa-plus"></i>
                  </a>
                </div>
              </div>

              <div class="card-content collapse show">
                <div class="card-body">
                  <!-- Alert Messages -->
                  @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif
                  @if(session('error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-times-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif
                  @if(session('warning'))
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif
                  @if(session('info'))
                  <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle"></i> {{ session('info') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif

                  <!-- Search Input -->
                  <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="{{ __('Search Holidays') }}">
                  </div>

                  <!-- Holidays Table -->
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
                            <!-- Dropdown with Three Dots and Icons -->
                            <div class="dropdown">
                              <button class="btn dropdown-toggle" type="button" id="actionMenu{{ $holiday->id }}"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="actionMenu{{ $holiday->id }}">
                                <a class="dropdown-item" href="{{ route('holiday.edit', $holiday) }}">
                                  <i class="fas fa-edit"></i> Edit
                                </a>
                                <a class="dropdown-item" href="{{ route('holiday.copy', $holiday) }}">
                                  <i class="fas fa-copy"></i> Copy
                                </a>
                                <form action="{{ route('holiday.destroy', $holiday) }}" method="POST"
                                  onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="dropdown-item">
                                    <i class="fas fa-trash-alt"></i> Delete
                                  </button>
                                </form>
                              </div>
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

                  <!-- Pagination -->
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
@endsection

@section("js")
<script>
  // Search filter functionality
  document.getElementById('search').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    document.querySelectorAll("tbody tr").forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
    });
  });

  // Initialize tooltips (using Bootstrap)
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
@endsection