@extends("layouts.master")

@section("title")
    {{ __("Attendance") }}
@endsection

@section("css")
<style>
 
  body {
      background-color: #f0f2f5;
  }

  .attendance-container {
      min-height: 60vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
  }
  
  .attendance-card {
      max-width: 800px;
      width: 100%;
      border: none;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
      overflow: hidden;
  }
  .attendance-card .card-header {
      background-color: #1da1f2;
      color: #fff;
      text-align: center;
      padding: 25px;
      font-size: 1.75rem;
      font-weight: 700;
  }
  .attendance-card .card-body {
      padding: 30px;
      background-color: #fff;
  }
  /* Button styling with icons */
  .btn-attendance {
      min-width: 160px;
      margin: 10px;
      font-size: 1.1rem;
  }
  .btn-attendance i {
      margin-right: 8px;
  }
  /* Badge styling */
  .badge-late {
      background-color: #ff4d4f;
      color: #fff;
      padding: 8px 15px;
      border-radius: 20px;
      font-size: 1rem;
  }
  .badge-extra {
      background-color: #52c41a;
      color: #fff;
      padding: 8px 15px;
      border-radius: 20px;
      font-size: 1rem;
  }
  .badge-zero {
      background-color: #d9d9d9;
      color: #555;
      padding: 8px 15px;
      border-radius: 20px;
      font-size: 1rem;
  }
  .table thead th {
      background-color: #fafafa;
      border-bottom: 2px solid #eaeaea;
      padding: 20px;
      font-size: 1.1rem;
  }
  .table td, .table th {
      vertical-align: middle;
      text-align: center;
      padding: 20px;
      font-size: 1rem;
  }
</style>
@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-body">
      <section id="attendance-section" class="attendance-container">
        <div class="card attendance-card">
          <div class="card-header">
            <i class="fas fa-calendar-check"></i> My Attendance
          </div>
          <div class="card-body">
            @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif

            @if(session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif

            <div class="mb-4 text-center">
              <!-- Check-In Form -->
              <form action="{{ route('attendanceHome.checkin') }}" method="POST" class="d-inline" id="checkin-form">
                @csrf
                <input type="hidden" name="latitude" id="checkin-latitude">
                <input type="hidden" name="longitude" id="checkin-longitude">
                <button type="submit" class="btn btn-primary btn-attendance">
                  <i class="fas fa-sign-in-alt"></i> Check In
                </button>
              </form>

              <!-- Check-Out Form -->
              <form action="{{ route('attendanceHome.checkout') }}" method="POST" class="d-inline" id="checkout-form">
                @csrf
                <input type="hidden" name="latitude" id="checkout-latitude">
                <input type="hidden" name="longitude" id="checkout-longitude">
                <button type="submit" class="btn btn-secondary btn-attendance">
                  <i class="fas fa-sign-out-alt"></i> Check Out
                </button>
              </form>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Late <i class="fas fa-clock"></i></th>
                    <th>Extra <i class="fas fa-plus-circle"></i></th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($attendances as $attendance)
                    <tr>
                      <td>{{ $attendance->date }}</td>
                      <td>{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('H:i:s') : '-' }}</td>
                      <td>{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('H:i:s') : '-' }}</td>
                      <td>
                        @if($attendance->late_minutes > 0)
                          <span class="badge-late">{{ $attendance->late_minutes }}</span>
                        @else
                          <span class="badge-zero">0</span>
                        @endif
                      </td>
                      <td>
                        @if($attendance->extra_minutes > 0)
                          <span class="badge-extra">{{ $attendance->extra_minutes }}</span>
                        @else
                          <span class="badge-zero">0</span>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5">No attendance records available.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection

@section("js")
<script>

  function setLocation() {
    if ("geolocation" in navigator) {
      navigator.geolocation.getCurrentPosition(function(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        
        document.getElementById('checkin-latitude').value = latitude;
        document.getElementById('checkin-longitude').value = longitude;
    
        document.getElementById('checkout-latitude').value = latitude;
        document.getElementById('checkout-longitude').value = longitude;
      }, function(error) {
        console.error("Error retrieving location:", error);
      });
    } else {
      alert("Geolocation is not supported by your browser.");
    }
  }
  
  window.onload = setLocation;
</script>
@endsection
