@extends("layouts.master")

@section("title")
    {{ __("project.Holiday List") }}
@endsection

@section("css")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }

        .card {
            border-radius: 15px;
            background: #fff;
            overflow: hidden;
            border: none;
        }

        .card-header {
            padding: 20px;
            background: #f0f4f8;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-body {
            padding: 30px;
        }

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

        .btn-light {
            background-color: #1da1f2;
            color: #fff;
            border-radius: 8px;
            padding: 10px 16px;
        }

        .btn-light:hover {
            background-color: #007bff;
        }

        .action-icon {
            background: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
            padding: 6px;
            color: #6c757d;
        }

        .action-icon:hover {
            opacity: 0.7;
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
                            <div class="card-header">
                                <h4 class="card-title m-0">
                                    <i class="fas fa-cogs mr-2"></i>{{ __("app.departments") }}
                                </h4>
                                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#createDepartmentModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead class="thead-custom">
                                            <tr>
                                                <th>{{__('app.id')}}</th>
                                                <th>{{__('app.name')}}</th>
                                                <th>{{__('app.created at')}}</th>
                                                <th>{{__('app.updated at')}}</th>
                                                <th>{{__('app.actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($departments as $department)
                                                <tr>
                                                    <td>{{ $department->id }}</td>
                                                    <td>{{ $department->name }}</td>
                                                    <td>{{ optional($department->created_at)->format('Y-m-d') }}</td>
                                                    <td>{{ optional($department->updated_at)->format('Y-m-d') }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <button type="button" class="action-icon text-warning" data-toggle="modal" data-target="#editDepartmentModal{{ $department->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <form id="delete-form-{{ $department->id }}" action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display:none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            <button type="button" class="action-icon text-danger" onclick="confirmDelete({{ $department->id }})">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Edit Department Modal -->
                                                <div class="modal fade" id="editDepartmentModal{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="editDepartmentModalLabel{{ $department->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form action="{{ route('departments.update', $department->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editDepartmentModalLabel{{ $department->id }}">{{ __('Edit Department') }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="name">{{ __('Department Name') }}</label>
                                                                        <input type="text" class="form-control" name="name" value="{{ $department->name }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">{{ __("No departments found") }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pagination mt-4">
                                    {{ $departments->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Create Department Modal -->
<div class="modal fade" id="createDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="createDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDepartmentModalLabel">{{ __('Add Department') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ __('Department Name') }}</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section("js")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '{{ __("Are you sure?") }}',
            text: "{{ __('You won\'t be able to revert this!') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1da1f2',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __("Yes, delete it!") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection