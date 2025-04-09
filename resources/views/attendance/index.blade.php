@extends("layouts.master")

@section("title", "Attendance Management")

@section("css")

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="{{ asset("app-assets/css/tablestyle.css") }}">
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
                        <div class="card shadow border-0">
                            {{-- <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form"> </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            </div> --}}
                            <div class="card-content collapse show">





                                <div class="card-header">
                                    <h4><i class="bi bi-calendar-check me-2" style="color:#fff"></i>
                                        Attendance Management
                                    </h4>
                                </div>


                                <div class="card-body">
                                    @if(session('success'))
                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                                    </div>
                                    @endif


                                    <div class="mb-4">
                                        <a href="{{ route('attendance.create') }}" class="btn "
                                            style="background-color: #1e9ff2;color:#fff">
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
                                                    <th>Late (hours)</th>
                                                    <th>Extra (hours)</th>
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
                                                            class="badge badge-late">{{ $attendance->late_hours }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-extra">
                                                            {{ $attendance->extra_hours }}
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
                                                                <button type="submit" class="btn btn-delete btn-action">
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

                                {{$attendances->links()}}



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
        language: { searchPlaceholder: "Search...", search: "" },
        paging: false,
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