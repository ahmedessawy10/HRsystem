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
                                    <i class="fas fa-setting-alt mr-2"></i>{{ __("app.jobpostions") }}
                                </h4>

                                <div>
                                    <a href="{{ route('jobpositions.create') }}" class="btn btn-light"
                                       data-toggle="tooltip" data-placement="top"
                                       title="{{ __('Add New Job Position') }}">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>



                                    <!-- Holidays Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped">
                                            <thead class="thead-custom">
                                                <tr>
                                                    <th>{{__("app.id")}}</th>
                                                    <th>{{__("app.department")}}</th>
                                                    <th>{{__("app.job position")}}</th>
                                                    <th>{{__("app.created at")}}</th>
                                                    <th>{{__("app.updated at")}}</th>
                                                    <th style="width: 20%;">{{__("app.actions")}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($jobpositions as $jobposition)
                                                <tr>
                                                    <td>{{ $jobposition->id}}</td>
                                                    <td>{{ $jobposition->department->name }}</td>
                                                    <td>{{ $jobposition->name }}</td>
                                                    <td>{{ $jobposition->created_at ? $jobposition->created_at->format('Y-m-d') : 'NULL' }}</td>
                                                    <td>{{ $jobposition->updated_at ? $jobposition->updated_at->format('Y-m-d') : 'NULL' }}</td>
                                                    <td>
                                                        <!-- Edit and Delete Buttons -->
                                                        <div class="d-flex gap-1 justify-content-center">
                                                            <a class="btn btn-warning text-white"
                                                               href="{{ route('jobpositions.edit', $jobposition->id) }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            <form action="{{ route('jobpositions.destroy', $jobposition->id) }}"
                                                                  method="POST"
                                                                  onsubmit="return confirmDelete({{ $jobposition->id }})">
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
                                                    <td colspan="6" class="text-center">{{ __("No job positions found") }}</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="pagination">
                                        {{ $jobpositions->links('pagination::bootstrap-4') }}
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __("Add New Job Position") }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('jobpositions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">{{__('app.department_name')}}</label>
                        <input type="text" name="department_name" class="form-control" id="department_name" required>
                    </div>
                    <!-- Add additional fields if necessary -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section("js")
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '{{ __("Are you sure?") }}',
            text: '{{ __("You won’t be able to revert this!") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __("Yes, delete it!") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
