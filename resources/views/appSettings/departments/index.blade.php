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
    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 16px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-left: 5px solid #1da1f2;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border-left: 5px solid #1da1f2;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border-left: 5px solid #ffc107;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 5px solid #dc3545;
    }

    .alert .close {
        margin-left: auto;
        font-size: 20px;
        cursor: pointer;
    }

    @media (max-width: 767px) {
        .table-responsive {
            margin-bottom: 20px;
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
                                <h4 class="card-title m-0">
                                    <i class="fas fa-setting-alt mr-2"></i>{{ __("app.departments") }}

                                </h4>


                                <div>
                                    {{-- <a href="{{ route('holiday.report') }}" class="btn btn-info mr-2"
                                    data-toggle="tooltip" data-placement="top" title="View Holiday Report">
                                    <i class="fas fa-file-alt"></i>
                                    </a> --}}
                                    <a href="{{ route('departments.create') }}" class="btn btn-light"
                                        data-toggle="tooltip" data-placement="top"
                                        title="{{ __('Add New Department') }}">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    {{-- <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="fas fa-plus"></i>
                                    </button> --}}
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
                                        {{-- <input type="text" id="search" class="form-control"
                                            placeholder="{{ __('Search Holidays') }}"> --}}
                                    </div>

                                    <!-- Holidays Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead class="thead-custom">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>name</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th style="width: 20%;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($departments as $department)
                                                <tr>
                                                    <td>{{ $department->id }}</td>
                                                    <td>{{ $department->name }}</td>

                                                    <td>{{ $department->created_at ? $department->created_at->format('Y-m-d') : 'NULL' }}
                                                    </td>
                                                    <td>{{ $department->updated_at ? $department->updated_at->format('Y-m-d') : 'NULL' }}
                                                    </td>
                                                    <td>
                                                        <!-- Dropdown with Three Dots and Icons -->
                                                        <div class="d-flex gap-1 justify-content-center">
                                                            <a class="btn btn-warning  text-white"
                                                                href="{{ route('departments.edit', $department->id) }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            <form
                                                                action="{{ route('departments.destroy', $department->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger text-white">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>


                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">{{ __("No holidays found") }}
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="pagination">
                                        {{ $departments->links('pagination::bootstrap-4') }}
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




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">{{__('app.department_name')}}</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="department">

                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type=" submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section("js")
<script>
    // Search filter functionality
//   document.getElementById('search').addEventListener('keyup', function() {
//     let value = this.value.toLowerCase();
//     document.querySelectorAll("tbody tr").forEach(row => {
//       row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
//     });
//   });

  // Initialize tooltips (using Bootstrap)
//   $(function () {
//     $('[data-toggle="tooltip"]').tooltip();
//   });
</script>
@endsection