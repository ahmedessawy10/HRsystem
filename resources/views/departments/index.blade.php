@extends('layouts.master')

@section('content')
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row"></div>
    <div class="content-body">
<div class="container mt-4">
    <h2>Department management </h2>
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Department Name " required class="form-control mb-2">
        <button type="submit" class="btn btn-primary">add</button>
    </form>

    <ul class="list-group mt-3">
        @foreach ($departments as $department)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $department->name }}</span>
                <div>
                    <!-- زر تعديل -->
                    <button class="btn btn-warning btn-sm edit-department" data-id="{{ $department->id }}" data-name="{{ $department->name }}">edit</button>

                    <!-- زر حذف -->
                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<!-- Modal لتعديل القسم -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Department edit </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" id="editDepartmentForm">
                @csrf @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editDepartmentId">
                    <label>Department Name  </label>
                    <input type="text" id="editDepartmentName" name="name" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">exit</button>
                </div>
            </form>

        </div>

    </div>

</div>
<a href="{{ route('settings.index') }}" class="btn btn-secondary mt-3"> Back</a>

<script>
    document.querySelectorAll('.edit-department').forEach(button => {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let name = this.getAttribute('data-name');

            document.getElementById('editDepartmentId').value = id;
            document.getElementById('editDepartmentName').value = name;
            document.getElementById('editDepartmentForm').action = `/departments/${id}`;
            $('#editDepartmentModal').modal('show');
        });
    });
</script>
@endsection
