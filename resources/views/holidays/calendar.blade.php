{{-- resources/views/holidays/calendar.blade.php --}}
@extends("layouts.master")

@section("title")
    {{ __("project.Holiday Calendar") }}
@endsection

@section("css")

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
<style>
  #calendar {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 10px;
    background-color: #f9f9f9;
  }

  .fc-daygrid-event {
    border-radius: 5px;
    padding: 5px;
    font-size: 12px;
    cursor: pointer;
  }
</style>
@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      {{-- Optional header content --}}
    </div>
    <div class="content-body">
      <div class="container">
        <h1>{{ __("project.Holiday Calendar") }}</h1>
        
        <select id="category-filter" class="form-control mb-3" style="width: 200px;">
          <option value="all">{{ __("project.All Holidays") }}</option>
          <option value="public">{{ __("project.Public Holidays") }}</option>
          <option value="religious">{{ __("project.Religious Holidays") }}</option>
        </select>

        <div id="calendar"></div>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventModalLabel">{{ __("project.Holiday Details") }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>{{ __("project.Occasion:") }}</strong> <span id="event-occasion"></span></p>
        <p><strong>{{ __("project.Date:") }}</strong> <span id="event-date"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="delete-event">{{ __("project.Delete") }}</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __("project.Close") }}</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section("js")

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var holidayEvents = [
      @foreach($holidays as $holiday)
      {
        title: '{{ $holiday->occation }}',
        start: '{{ \Carbon\Carbon::parse($holiday->date)->format('Y-m-d') }}',
        category: '{{ $holiday->category }}',
        id: '{{ $holiday->id }}'
      },
      @endforeach
    ];
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: holidayEvents,
      eventClick: function(info) {
        document.getElementById('event-occasion').textContent = info.event.title;
        document.getElementById('event-date').textContent = info.event.start.toISOString().split('T')[0];
        
        document.getElementById('delete-event').onclick = function() {
          if (confirm("{{ __('project.Are you sure you want to delete this holiday?') }}")) {
            fetch('/holidays/' + info.event.id, {
              method: 'DELETE',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              }
            }).then(response => response.json()).then(data => {
              if (data.success) {
                alert("{{ __('project.Holiday deleted successfully!') }}");
                info.event.remove();
              } else {
                alert("{{ __('project.Error deleting holiday.') }}");
              }
            });
          }
        };
        
        $('#eventModal').modal('show');
      }
    });
    
    document.getElementById('category-filter').addEventListener('change', function() {
      var category = this.value;
      calendar.removeAllEvents();
      calendar.addEventSource(
        category === 'all' ? holidayEvents : holidayEvents.filter(event => event.category === category)
      );
    });
    
    calendar.render();
  });
</script>
@endsection
