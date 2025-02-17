@extends("layouts.master")

@section("title", "Attendance Management")

@section("css")
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    body {
        background-color: #f8f9fa;
        color: #333;
    }

    .card {
        border-radius: 8px;
        background: #ffffff;
        border: none;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(45deg, #2c3e50, #34495e);
        color: white;
        text-align: center;
        border-radius: 8px 8px 0 0;
        padding: 1.5rem;
    }

    .card-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .table thead {
        background-color: #34495e;
        color: white;
    }

    .btn-filter {
        background-color: #2c3e50;
        color: white;
        transition: 0.3s;
        border: none;
    }

    .btn-filter:hover {
        background-color: white;
        color: #2c3e50;
        border: 1px solid #2c3e50;
    }

    .badge-late {
        background-color: #e74c3c;
        font-weight: bold;
        color: white;
    }

    .badge-extra {
        background-color: #2ecc71;
        font-weight: bold;
        color: white;
    }

    th,
    td {
        text-align: center;
        vertical-align: middle;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 6px;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
    }

    .btn-edit {
        background-color: #3498db;
        color: white;
    }

    .btn-edit:hover {
        background-color: white;
        color: #3498db;
        border: 1px solid #3498db;
    }

    .btn-delete {
        background-color: #e74c3c;
        color: white;
    }

    .btn-delete:hover {
        background-color: white;
        color: #e74c3c;
        border: 1px solid #e74c3c;
    }

    .alert-success {
        background-color: #2ecc71;
        color: white;
        border: none;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }
</style>
@endsection

@section("content")
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">

            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form"> </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            </div> --}}
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="card-text">
                                        <div class="container py-4">
                                            <div class="card shadow border-0">

                                                <div class="card-header">
                                                    <h4><i class="bi bi-calendar-check me-2"></i> Attendance Management
                                                    </h4>
                                                </div>


                                                <div class="card-body">
                                                    @if(session('success'))
                                                    <div class="alert alert-success d-flex align-items-center"
                                                        role="alert">
                                                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                                                    </div>
                                                    @endif


                                                    <div class="mb-4">
                                                        <a href="{{ route('attendance.create') }}"
                                                            class="btn btn-primary">
                                                            <i class="bi bi-plus-circle me-2"></i> Add New Attendance
                                                        </a>
                                                    </div>

                                                    <div class="row g-3 mb-4">
                                                        <div class="col-md-5">
                                                            <label class="form-label fw-semibold text-dark">Start
                                                                Date</label>
                                                            <input type="date" id="start-date" class="form-control">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="form-label fw-semibold text-dark">End
                                                                Date</label>
                                                            <input type="date" id="end-date" class="form-control">
                                                        </div>
                                                        <div class="col-md-2 d-flex align-items-end">
                                                            <button class="btn btn-filter w-100" id="filter-btn"><i
                                                                    class="bi bi-funnel me-2"></i>
                                                                Filter</button>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table id="attendanceTable"
                                                            class="table table-bordered table-striped align-middle">
                                                            <thead>
                                                                <tr>
                                                                    <th>Employee</th>
                                                                    <th>Date</th>
                                                                    <th>Time In</th>
                                                                    <th>Time Out</th>
                                                                    <th>Late (min)</th>
                                                                    <th>Extra (min)</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($attendances as $attendance)
                                                                <tr>
                                                                    <td>{{ $attendance->user->name }}</td>
                                                                    <td>{{ $attendance->date }}</td>
                                                                    <td>{{ $attendance->time_in }}</td>
                                                                    <td>{{ $attendance->time_out }}</td>
                                                                    <td>
                                                                        <span
                                                                            class="badge badge-late">{{ $attendance->late_minutes }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge badge-extra">
                                                                            {{ $attendance->extra_minutes }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="action-buttons">
                                                                            <a href="{{ route('attendance.edit', $attendance->id) }}"
                                                                                class="btn btn-edit btn-action">
                                                                                <i class="bi bi-pencil"></i> Edit
                                                                            </a>
                                                                            <form
                                                                                action="{{ route('attendance.destroy', $attendance->id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Are you sure?');">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-delete btn-action">
                                                                                    <i class="bi bi-trash"></i> Delete
                                                                                </button>
                                                                            </form>
                                                                        </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
    let table = $('#attendanceTable').DataTable({
        responsive: false,
        language: { searchPlaceholder: "Search...", search: "" }
    });

    $("#filter-btn").on("click", function() {
        let startDate = $("#start-date").val();
        let endDate = $("#end-date").val();

        if (!startDate || !endDate) {
            alert("Please select both start and end dates.");
            return;
        }

        let start = new Date(startDate);
        let end = new Date(endDate);

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            let rowDate = new Date(data[1]); 
            return rowDate >= start && rowDate <= end;
        });

        table.draw();
        $.fn.dataTable.ext.search.pop();
    });
});
</script>
@endsection