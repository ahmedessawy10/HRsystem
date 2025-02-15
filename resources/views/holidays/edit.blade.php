{{-- resources/views/holidays/edit.blade.php --}}
@extends("layouts.master")

@section("title")
    {{ __("project.Edit Holiday") }}
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
      <section id="basic-form-layouts">
        <div class="row match-height">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{ __("project.Edit Holiday") }}</h4>
                <a class="heading-elements-toggle">
                  <i class="la la-ellipsis-v font-medium-3"></i>
                </a>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  @if ($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                  <form action="{{ route('holiday.update', $holiday) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                      <label for="occation" class="form-label">{{ __("project.Occation") }}</label>
                      <input type="text" class="form-control" id="occation" name="occation" value="{{ old('occation', $holiday->occation) }}" required>
                    </div>
                    <div class="mb-3">
                      <label for="date" class="form-label">{{ __("project.Date") }}</label>
                      <input type="date" class="form-control" id="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($holiday->date)->format('Y-m-d')) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                      {{ __("project.Update Holiday") }}
                    </button>
                  </form>
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
