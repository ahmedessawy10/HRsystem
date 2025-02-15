@extends("layouts.master")

@section("title", "Add New Attendance")

@section("css")
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
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
    .card-header h4 {
        margin: 0;
        font-weight: 600;
    }
    .form-control {
        border-radius: 6px;
        border: 1px solid #ddd;
    }
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
</style>
@endsection

@section("content")
<div class="container py-4">
    <div class="card shadow border-0">
        
        <div class="card-header">
            <h4><i class="bi bi-calendar-check me-2"></i> Add New Attendance</h4>
        </div>

      
        <div class="card-body">
            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                 <select name="user" id="">
                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->fullname}}</option>
                    @endforeach
                 </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Time In</label>
                    <input type="time" name="time_in" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Time Out</label>
                    <input type="time" name="time_out" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Late Minutes</label>
                    <input type="number" name="late_minutes" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Extra Minutes</label>
                    <input type="number" name="extra_minutes" class="form-control" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection