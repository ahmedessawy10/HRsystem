@extends("layouts.master")

@section("title", "Edit Attendance")

@section("css")

<style>
    body {
        background-color: #f8f9fa;
        color: #333;
    }

    .card {
        width: 50%;
        margin: auto;
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

    .form-control {
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .error-feedback {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section("content")
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-header">
            <h4><i class="bi bi-calendar-check me-2"></i> Edit Attendance</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" id="attendanceForm">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Employee Name</label>
                    <input type="text" readonly name="employee_name" class="form-control" required
                        value="{{ old('employee_name', $attendance->user->name) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="fullname" readonly class="form-control" required
                        value="{{ old('fullname', $attendance->user->fullname) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required
                        value="{{ old('date', $attendance->date) }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Time In</label>
                    <input type="time" name="time_in" id="timeIn" class="form-control" required
                        value="{{ old('time_in',optional($attendance->time_in)->format('H:i')) }}">
                </div>
                <div class="mb-3">

                    <label class="form-label">Time Out</label>
                    <input type="time" name="time_out" id="timeOut" class="form-control" required
                        value="{{ old('time_out',optional($attendance->time_out)->format('H:i')) }}">
                </div>
                {{-- <div class="mb-3">
                    <label class="form-label">Late Minutes</label>
                    <input type="number" name="late_minutes" id="lateMinutes" class="form-control" required readonly
                        value="{{ old('late_minutes', $attendance->late_minutes) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Extra Minutes</label>
            <input type="number" name="extra_minutes" id="extraMinutes" class="form-control" required readonly
                value="{{ old('extra_minutes', $attendance->extra_minutes) }}">
        </div> --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-2"></i> Save
            </button>
        </div>
        </form>
    </div>
</div>
</div>
@endsection

@section("js")
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
  
    const STANDARD_START = '08:00';
    const STANDARD_END = '17:00';
    
    function calculateMinutes() {
        const timeIn = $('#timeIn').val();
        const timeOut = $('#timeOut').val();
        
        if (timeIn && timeOut) {
          
            const standardStartTime = new Date(`2000-01-01T${STANDARD_START}`);
            const actualTimeIn = new Date(`2000-01-01T${timeIn}`);
            const lateMinutes = actualTimeIn > standardStartTime ? 
                Math.floor((actualTimeIn - standardStartTime) / 60000) : 0;
            
            const standardEndTime = new Date(`2000-01-01T${STANDARD_END}`);
            const actualTimeOut = new Date(`2000-01-01T${timeOut}`);
            const extraMinutes = actualTimeOut > standardEndTime ? 
                Math.floor((actualTimeOut - standardEndTime) / 60000) : 0;
            
            $('#lateMinutes').val(lateMinutes);
            $('#extraMinutes').val(extraMinutes);
        }
    }
    
    $('#timeIn, #timeOut').on('change', calculateMinutes);

    $('#attendanceForm').on('submit', function(e) {
        const timeIn = new Date(`2000-01-01T${$('#timeIn').val()}`);
        const timeOut = new Date(`2000-01-01T${$('#timeOut').val()}`);
        
        if (timeOut <= timeIn) {
            e.preventDefault();
            alert('Time out must be later than time in');
            return false;
        }
        
        return true;
    });
});
</script>
@endsection