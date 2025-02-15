{{-- resources/views/holidays/report.blade.php --}}
@extends("layouts.master")

@section("title")
    {{ __("project.Holiday Reports") }}
@endsection

@section("css")

@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      {{-- Optional header content --}}
    </div>
    <div class="content-body">
      <div class="container">
        <h1>{{ __("project.Holiday Reports") }}</h1>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Occation</th>
              <th>Date</th>
              <th>Created At</th>
              <th>Updated At</th>
            </tr>
          </thead>
          <tbody>
            @foreach($holidays as $holiday)
            <tr>
              <td>{{ $holiday->id }}</td>
              <td>{{ $holiday->occation }}</td>
              <td>{{ \Carbon\Carbon::parse($holiday->date)->format('Y-m-d') }}</td>
              <td>{{ $holiday->created_at ? $holiday->created_at->format('Y-m-d') : 'NULL' }}</td>
              <td>{{ $holiday->updated_at ? $holiday->updated_at->format('Y-m-d') : 'NULL' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section("js")

@endsection
