{{-- resources/views/holidays/create.blade.php --}}
@extends("layouts.master")

@section("title")
    {{ __("project.Add Holiday") }}
@endsection

@section("css")
<style>

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7fc;
  }

  .card {
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
    /* transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out; */
  }

  /* .card:hover {
    box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
  } */

  .card-header {
    background-color: #007bff; 
    color: #fff;
    padding: 20px;
    border-radius: 15px 15px 0 0;
    font-size: 22px;
    font-weight: 700;
    letter-spacing: 1px;
  }

  .card-body {
    padding: 40px;
    background-color: #f9fafb;
    border-radius: 0 0 15px 15px;
  }

  
  .form-label {
    font-size: 16px;
    font-weight: 600;
    color: #3a3a3a;
    margin-bottom: 10px;
  }

  .form-control {
    border-radius: 10px;
    padding: 15px;
    font-size: 16px;
    margin-bottom: 25px;
    border: 1px solid #ddd;
    background-color: #fff;
    transition: border 0.3s ease, box-shadow 0.3s ease;
  }

  .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
  }

  .btn-success {
    background-color: #007bff !important; 
    color: white !important;
    font-size: 18px !important;
    padding: 15px 40px !important;
    border-radius: 10px !important;
    border: none !important;
    /* transition: background-color 0.3s ease, transform 0.2s ease-in-out, box-shadow 0.2s ease !important; */
}

.btn-success:hover {
    background-color: #0056b3 !important; 
    /* transform: translateY(-3px) !important; */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2) !important;
}

.btn-success:active {
    background-color: #004085 !important; 
    transform: translateY(0) !important;
    box-shadow: none !important;
}


  .alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 25px;
    font-size: 16px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
  }

  .alert-danger ul {
    padding-left: 20px;
  }

  .alert-danger li {
    list-style-type: disc;
  }

  .card-body form {
    max-width: 600px;
    margin: 0 auto;
  }

  @media (max-width: 767px) {
    .card-body {
      padding: 25px;
    }

    .btn-success {
      font-size: 16px;
      padding: 12px 30px;
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
        <div class="row match-height">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{ __("project.Add Holiday") }}</h4>
              </div>
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

                <form action="{{ route('holiday.store') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label for="occation" class="form-label">{{ __("project.Occation") }}</label>
                    <input type="text" class="form-control" id="occation" name="occation" value="{{ old('occation') }}" required>
                  </div>
                  <div class="mb-3">
                    <label for="date" class="form-label">{{ __("project.Date") }}</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
                  </div>
                  <button type="submit" class="btn btn-success">
                    {{ __("project.Create Holiday") }}
                  </button>
                </form>
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
