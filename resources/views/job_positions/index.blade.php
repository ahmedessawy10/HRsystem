@extends('layouts.master')

@section('content')
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-body">
      <div class="container">
        <h2>Job Position Management</h2>
 <!-- ✅ اختيار القسم -->
 <div class="form-group">
          <label for="department">Select Department:</label> -->
          <!-- <select id="department" class="form-control">
            <option value="">-- Select Department --</option>
            @foreach($departments as $department)
              <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
          </select>
        </div>
        <!-- ✅ زر إضافة وظيفة جديدة -->
        <button class="btn btn-primary mt-3" id="addJobPositionBtn">Add Job Position</button>

        <!-- ✅ جدول عرض الوظائف -->
        <table class="table table-bordered mt-3">
          <thead>
            <tr>
              <th>Department Name</th>
              <th>Job Position</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($jobpositions as $jobposition)
            <tr>
              <td>{{ $jobposition->department?->name }}</td>
              <td>{{ $jobposition->name }}</td>
              <td>
                <button class="btn btn-warning btn-sm edit-jobposition"
                        data-id="{{ $jobposition->id }}"
                        data-name="{{ $jobposition->name }}"
                        data-department="{{ $jobposition->department_id }}">
                  Edit
                </button>
                <form action="{{ route('job_positions.destroy', $jobposition->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
<!-- Popup للتعديل والإضافة -->
<div id="editPopup" class="modal hidden">
  <div class="modal-content">
    <span class="close-popup">&times;</span>
    <h3 id="modalTitle">Job Position</h3>
    <input type="hidden" id="editJobPositionId">
    
    <label>Department:</label>
    <select id="editJobPositionDepartment" class="form-control">
        <option value="">-- Select Department --</option>
        @foreach ($departments as $department)
            <option value="{{ $department->id }}">{{ $department->name }}</option>
        @endforeach
    </select>
    
    <label>Job Position Name:</label>
    <input type="text" id="editJobPositionName" class="form-control">
    
    <button id="saveJobPosition" class="btn btn-success">Save</button>
    <button class="btn btn-secondary close-popup">Exit</button>
  </div>
</div>


      <a href="{{ route('settings.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
  // ✅ فتح نافذة الإضافة
  $('#addJobPositionBtn').click(function() {
    $('#modalTitle').text('Add Job Position');
    $('#editJobPositionId').val('');
    $('#editJobPositionName').val('');
    $('#editJobPositionDepartment').val('');
    $('#editPopup').fadeIn();
  });

  // ✅ فتح نافذة التعديل
  $(document).on('click', '.edit-jobposition', function () {
    const jobId = $(this).data('id');
    const jobName = $(this).data('name');
    const departmentId = $(this).data('department-id');

    $('#modalTitle').text('Edit Job Position');
    $('#editJobPositionId').val(jobId);
    $('#editJobPositionName').val(jobName);
    $('#editJobPositionDepartment').val(departmentId);
    $('#editPopup').fadeIn();
  });

  // ✅ إغلاق النافذة
  $(document).on('click', '.close-popup', function () {
    $('#editPopup').fadeOut();
  });

  // ✅ حفظ الوظيفة (إضافة أو تعديل)
  $('#saveJobPosition').click(function () {
    const id = $('#editJobPositionId').val();
    const name = $('#editJobPositionName').val();
    const departmentId = $('#editJobPositionDepartment').val();

    if (!name || !departmentId) {
      alert('يرجى إدخال جميع الحقول!');
      return;
    }

    const url = id ? `/job_positions/${id}` : '/job_positions';
    const method = id ? 'PUT' : 'POST';

    $.ajax({
      url: url,
      type: 'POST', 
      data: {
        _token: '{{ csrf_token() }}',
        name: name,
        department_id: departmentId,
        _method: method
      },
      success: function(response) {
        alert(response.message);
        location.reload();
      },
      error: function(xhr) {
        console.error('Error:', xhr.responseText);
        alert('حدث خطأ أثناء الحفظ');
      }
    });
  });
});

</script>
@endsection
