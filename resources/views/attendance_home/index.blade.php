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
    padding: 20px;
  }

  .attendance-card {
    width: 100%;
    background-color: #fff;
    border: none;
    border-radius: 0;
  }

  .attendance-card .card-body {
    padding: 30px;
    background-color: #fff;
  }

  .btn-attendance {
    min-width: 160px;
    margin: 10px;
    font-size: 1.1rem;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    background-color: #1da1f2;
    color: white;
    transition: background-color 0.3s ease;
  }

  .btn-attendance i {
    margin-right: 8px;
  }

  .btn-checkout {
    background-color: #6c757d;
  }

  .badge-late {
    color: #ff4d4f;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 1rem;
  }

  .badge-extra {
    color: #52c41a;
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

  .table td,
  .table th {
    vertical-align: middle;
    text-align: center;
    padding: 20px;
    font-size: 1rem;
    border: none;
  }

  .pagination {
    display: flex;
    justify-content: center;
    margin-top: 10px;
    gap: 10px;
    flex-wrap: wrap;
  }

  .pagination .page-link {
    color: #1da1f2;
    background-color: #fff;
    border: 1px solid #dee2e6;
    padding: 8px 14px;
    border-radius: 6px;
    transition: all 0.3s ease;
  }

  .pagination .page-item.active .page-link {
    background-color: #1da1f2;
    color: white;
    border-color: #1da1f2;
  }

  .pagination .page-link:hover {
    background-color: #0d8ddb;
    color: white;
    text-decoration: none;
  }

  .pagination .page-item.disabled .page-link {
    color: #ccc;
    pointer-events: none;
    background-color: #f5f5f5;
  }

  .pagination-info {
    text-align: center;
    margin-top: 20px;
    color: #666;
    font-size: 0.95rem;
  }
</style>
@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-body">
      <section id="attendance-section" class="attendance-container">
        <div class="attendance-card">
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
                <button type="submit" class="btn btn-attendance">
                  <i class="fas fa-sign-in-alt"></i> Check In
                </button>
              </form>

              <!-- Check-Out Form -->
              <form action="{{ route('attendanceHome.checkout') }}" method="POST" class="d-inline" id="checkout-form">
                @csrf
                <input type="hidden" name="latitude" id="checkout-latitude">
                <input type="hidden" name="longitude" id="checkout-longitude">
                <button type="submit" class="btn btn-attendance btn-checkout">
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
                        @if($attendance->late_hours > 0)
                          <span class="badge-late">{{ $attendance->late_hours }}</span>
                        @else
                          <span class="badge-zero">0</span>
                        @endif
                      </td>
                      <td>
                        @if($attendance->extra_hours > 0)
                          <span class="badge-extra">{{ $attendance->extra_hours }}</span>
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

            <!-- Result Info + Pagination at Bottom -->
            <div class="mt-4 d-flex flex-column align-items-center">
              <!-- @if($attendances->total() > 0)
              <div class="pagination-info">
                Showing {{ $attendances->firstItem() }} to {{ $attendances->lastItem() }} of {{ $attendances->total() }} results
              </div>
              @endif -->
              <div>
                {{ $attendances->links() }}
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
<script>
  function setLocation() {
    if ("geolocation" in navigator) {
      navigator.geolocation.getCurrentPosition(function (position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        document.getElementById('checkin-latitude').value = latitude;
        document.getElementById('checkin-longitude').value = longitude;
        document.getElementById('checkout-latitude').value = latitude;
        document.getElementById('checkout-longitude').value = longitude;
      }, function (error) {
        console.error("Error retrieving location:", error);
      });
    } else {
      alert("Geolocation is not supported by your browser.");
    }
  }

  window.onload = setLocation;
</script>
@endsection
