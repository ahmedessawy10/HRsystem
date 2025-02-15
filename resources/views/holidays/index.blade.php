@extends("layouts.master")

@section("title")
    {{ __("project.Holiday List") }}
@endsection

@section("css")
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .card {
    border-radius: 12px;
    border: 1px solid #f1f1f1;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
  }

  .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }

  .card-header {
    color: #fff;
    padding: 20px;
    border-radius: 12px 12px 0 0;
    font-size: 22px;
    font-weight: 800;
  }

  .card-body {
    padding: 25px;
  }

  .table th, .table td {
    padding: 12px;
    text-align: center;
    font-size: 14px;
    font-weight: 500;
  }

  .table-hover tbody tr:hover {
    background-color: #f9f9f9;
  }

  .table-striped tbody tr:nth-of-type(odd) {
    background-color: #fafafa;
  }

  #search {
    border-radius: 25px;
    padding-left: 20px;
    font-size: 15px;
    border: 1px solid #ccc;
    background-color: #f7f8fa;
    width: 100%;
    margin-bottom: 20px;
    transition: border-color 0.3s ease;
  }

  #search:focus {
    border-color: #0056b3;
    box-shadow: 0 0 5px rgba(0, 86, 179, 0.3);
    background-color: #fff;
  }

  .btn {
    background-color: transparent;
    border: none;
    padding: 10px 15px;
    font-size: 18px;
    cursor: pointer;
    color: #007bff;
    transition: transform 0.3s ease, color 0.3s ease;
  }

  .btn:hover {
    transform: scale(1.0);
    color: #0056b3;
  }

  .btn-light {
    color: #343a40;
  }

  .btn-info {
    color: rgb(3, 13, 41);
  }

  .btn-warning {
    color: #ffc107;
  }

  .btn-danger {
    color: #dc3545;
  }

  .btn i {
    font-size: 20px;
  }

  .thead-custom th {
    background-color: #007bff;
    color: #fff;
    font-weight: 600;
  }

  /* Pagination Styling */
  .pagination {
    justify-content: center;
    margin-top: 20px;
  }

  .pagination .page-link {
    border-radius: 50px;
    padding: 8px 16px;
    margin: 0 5px;
    background-color: #f1f1f1;
    color: #007bff;
    border: 1px solid #ddd;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .pagination .page-link:hover {
    background-color: #007bff;
    color: #fff;
  }

  .pagination .active .page-link {
    background-color: #0056b3;
    color: #fff;
  }

  .pagination .page-link i {
    font-size: 16px;
  }

  .pagination .page-link:hover i {
    transform: scale(1.2);
  }


  .alert {
    padding: 15px 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 15px;
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 20px;
    transition: transform 0.3s ease, opacity 0.3s ease;
  }

  .alert-success {
    background-color: #d4edda;
    color: #155724;
    border-left: 5px solid #28a745;
  }

  .alert-success i {
    font-size: 24px;
  }

  .alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
    border-left: 5px solid #17a2b8;
  }

  .alert-info i {
    font-size: 24px;
  }

  .alert-warning {
    background-color: #fff3cd;
    color: #856404;
    border-left: 5px solid #ffc107;
  }

  .alert-warning i {
    font-size: 24px;
  }

  .alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-left: 5px solid #dc3545;
  }

  .alert-danger i {
    font-size: 24px;
  }

  .alert-dismissible {
    padding-right: 50px;
  }

  .alert .close {
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 20px;
    color: inherit;
    cursor: pointer;
  }

  .alert:hover {
    transform: translateY(-5px);
    opacity: 0.9;
  }

  @media (max-width: 767px) {
    .table-responsive {
      margin-bottom: 20px;
    }

    .btn {
      font-size: 16px;
      padding: 8px 12px;
    }

    #search {
      width: 100%;
    }
  }
</style>
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
                <h4 class="card-title m-0">{{ __(" Holiday List") }}</h4>
                <a href="{{ route('holiday.create') }}" class="btn btn-light" data-toggle="tooltip" data-placement="top" title="{{ __('project.Add New Holiday') }}">
                  <i class="la la-plus"></i>
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

                  <div class="mb-3">
                    <input type="text" id="search" class="form-control" placeholder="{{ __('project.Search Holidays') }}">
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
                            <a href="{{ route('holiday.edit', $holiday) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="{{ __('project.Edit Holiday') }}">
                              <i class="la la-edit"></i>
                            </a>
                            <a href="{{ route('holiday.copy', $holiday) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="{{ __('project.Copy Holiday') }}">
                              <i class="la la-copy"></i>
                            </a>
                            <form action="{{ route('holiday.destroy', $holiday) }}" method="POST" class="d-inline-block" onsubmit="return confirm('{{ __('project.Are you sure?') }}');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="{{ __('project.Delete Holiday') }}">
                                <i class="la la-trash"></i>
                              </button>
                            </form>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="6" class="text-center">{{ __("project.No holidays found") }}</td>
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
@endsection

@section("js")
<script>
  document.getElementById('search').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");
    rows.forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
    });
  });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
@endsection
