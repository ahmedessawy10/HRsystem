@extends('layouts.master')

@section('content')
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row"></div>
    <div class="content-body">
<div class="container">
    <h2>Job Position Management</h2>

    <!-- ✅ اختيار القسم -->
    <div class="form-group">
        <label for="department">Select Department:</label>
        <select id="department" class="form-control">
            <option value="">-- Select Department --</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- ✅ جدول عرض الموظفين -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Job Position</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="employees-table">
            <!-- سيتم ملء البيانات هنا بواسطة AJAX -->
             
            @foreach ($jobpositions as $jobposition)
            <tr>
                              <td>{{ $jobposition->department?->name }}</td>
                              <td>{{ $jobposition->name }}</td>
                              </tr>
                              @endforeach
                        
        </tbody>
    </table>
</div>
<a href="{{ route('settings.index') }}" class="btn btn-secondary mt-3"> Back</a>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    let getEmployeesRoute = "{{ route('job_positions.getEmployees') }}";
    let updateJobPositionRoute = "{{ route('job_positions.updateJobPosition') }}";
    let deleteJobPositionRoute = "{{ route('job_positions.deleteJobPosition') }}";

    $('#department').change(function () {
        let departmentId = $(this).val();
        
        if (departmentId) {
            $.ajax({
                url: getEmployeesRoute,
                type: "GET",
                data: { department_id: departmentId },
                success: function (response) {
                    let rows = '';
                    if (response.length === 0) {
                        rows = '<tr><td colspan="3" class="text-center text-muted">لا يوجد موظفون في هذا القسم</td></tr>';
                    } else {
                        response.forEach(function (employee) {
                            rows += `
                                <tr id="employee-${employee.id}">
                                    <td>${employee.name}</td>
                                    <td>
                                        <input type="text" class="form-control job-position-input" data-employee-id="${employee.id}" value="${employee.job_position || ''}">
                                    </td>
                                    <td>
                                        <button class="btn btn-success save-job-position" data-employee-id="${employee.id}">حفظ</button>
                                        <button class="btn btn-danger delete-job-position" data-employee-id="${employee.id}">حذف</button>
                                    </td>
                                    <td class="status-message text-success"></td>
                                </tr>
                            `;
                        });
                    }
                    $('#employees-table').html(rows);
                },
                error: function () {
                    alert("حدث خطأ أثناء جلب الموظفين.");
                }
            });
        } else {
            $('#employees-table').html('');
        }
    });

    // ✅ حفظ التعديل أو الإضافة
    $(document).on('click', '.save-job-position', function () {
        let employeeId = $(this).data('employee-id');
        let jobPosition = $(`.job-position-input[data-employee-id="${employeeId}"]`).val();
        let statusMessage = $(`#employee-${employeeId} .status-message`);

        $.ajax({
            url: updateJobPositionRoute,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                employee_id: employeeId,
                job_position: jobPosition
            },
            success: function (response) {
                statusMessage.text(response.message).css('color', 'green');
            },
            error: function () {
                statusMessage.text("فشل في تحديث المسمى الوظيفي").css('color', 'red');
            }
        });
    });

    // ✅ حذف المسمى الوظيفي
    $(document).on('click', '.delete-job-position', function () {
        let employeeId = $(this).data('employee-id');

        $.ajax({
            url: deleteJobPositionRoute,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                employee_id: employeeId
            },
            success: function (response) {
                $(`#employee-${employeeId}`).fadeOut(500, function () { $(this).remove(); });
            },
            error: function () {
                alert("فشل في حذف المسمى الوظيفي.");
            }
        });
    });
});
</script>
@endsection

