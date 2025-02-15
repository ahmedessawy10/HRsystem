@extends("layouts.master")

@section("title")
    {{ __("Attendance") }}
@endsection

@section("css")

@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
 
    </div>
    <div class="content-body">

      <section id="attendance-section">
        <div class="row match-height">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title" id="attendance-form-title">My Attendance</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content collapse show">
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

                  <div class="mb-3">
                      <form action="{{ route('attendance.checkin') }}" method="POST" style="display: inline;">
                          @csrf
                          <button type="submit" class="btn btn-primary">Check In</button>
                      </form>

                      <form action="{{ route('attendance.checkout') }}" method="POST" style="display: inline;">
                          @csrf
                          <button type="submit" class="btn btn-secondary">Check Out</button>
                      </form>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Check-In Time</th>
                          <th>Check-Out Time</th>
                          <th>Late Minutes</th>
                          <th>Extra Minutes</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($attendances as $attendance)
                          <tr>
                            <td>{{ $attendance->date }}</td>
                            <td>{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('H:i:s') : '-' }}</td>
                            <td>{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('H:i:s') : '-' }}</td>
                            <td>{{ $attendance->late_minutes ?? 0 }}</td>
                            <td>{{ $attendance->extra_minutes ?? 0 }}</td>
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
            </div>
          </div>
        </div>
      </section>

    </div>
  </div>
</div>
@endsection

@section("js")
    
@endsection
