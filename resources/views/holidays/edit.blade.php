@extends("layouts.master")

@section("title")
    {{ __("project.Edit Holiday") }}
@endsection

@section("css")
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f4f8;
  }
  .card {
    max-width: 500px; /* Reduce card width */
    margin: 50px auto; /* Center card and add vertical spacing */
    border-radius: 15px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    background-color: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    border: none;
  }
  .card-header {
    background: #f0f4f8;
    color: #fff;
    padding: 20px;
    font-size: 22px;
    font-weight: 700;
    text-align: center;
  }
  .card-body {
    padding: 30px;
    background-color: #f9fafb;
  }
  .form-label {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
  }
  .form-label i {
    margin-right: 8px;
  }
  .form-control {
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 16px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    background-color: #fff;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }
  .form-control:focus {
    border-color: #1da1f2;
    box-shadow: 0 0 8px rgba(29, 161, 242, 0.3);
    outline: none;
  }
  .btn-primary {
    background: linear-gradient(45deg, #1da1f2, #187fc2);
    color: #fff;
    font-size: 18px;
    padding: 12px 30px;
    border-radius: 10px;
    border: none;
    transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    display: block;
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
  }
  .btn-primary:hover {
    background: linear-gradient(45deg, #187fc2, #1467a0);
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  }
  @media (max-width: 767px) {
    .card-body {
      padding: 20px;
    }
    .btn-primary {
      font-size: 16px;
      padding: 10px 25px;
    }
    .form-label {
      font-size: 14px;
    }
    .form-control {
      font-size: 14px;
    }
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
      <section id="basic-form-layouts">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">
                  <i class="fas fa-edit mr-2"></i>{{ __("Edit Holiday") }}
                </h4>
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
                      <label for="occation" class="form-label">
                        <i class="fas fa-flag mr-2"></i>{{ __("Occation") }}
                      </label>
                      <input type="text" class="form-control" id="occation" name="occation" value="{{ old('occation', $holiday->occation) }}" required>
                    </div>
                    <div class="mb-3">
                      <label for="date" class="form-label">
                        <i class="fas fa-calendar-alt mr-2"></i>{{ __("Date") }}
                      </label>
                      <input type="date" class="form-control" id="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($holiday->date)->format('Y-m-d')) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-check mr-2"></i>{{ __("Update Holiday") }}
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
