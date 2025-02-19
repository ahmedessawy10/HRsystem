@extends("layouts.master")

@section("title")
{{ __("project.Add Holiday") }}
@endsection

@section("css")
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f4f8;
    }

    .card {
        max-width: 500px;
        margin: 50px auto;
        border-radius: 15px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
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
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        outline: none;
    }

    .btn-success {
        background: linear-gradient(45deg, #1e90ff, #007bff);
        color: #fff;
        font-size: 18px;
        padding: 12px 30px;
        border-radius: 10px;
        border: none;
        transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        display: block;
        width: 100%;
        max-width: 300px;
        margin: 20px auto 0 auto;
    }

    .btn-success:hover {
        background: linear-gradient(45deg, #007bff, #0056b3);
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-success:active {
        background: #0056b3;
        transform: translateY(0);
        box-shadow: none;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 16px;
    }

    .alert-danger ul {
        padding-left: 20px;
    }

    .alert-danger li {
        list-style-type: disc;
    }

    @media (max-width: 767px) {
        .card-body {
            padding: 20px;
        }

        .btn-success {
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
                                    <i class="fas fa-calendar-plus mr-2"></i> {{ __("app.edit jobposition") }}
                                </h4>
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

                                <form action="{{ route('jobpositions.update',$job->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="mb-3">
                                        <label for="occation" class="form-label">
                                            <i class="fas fa-flag mr-2"></i> {{ __("app.department_name") }}
                                        </label>
                                        <select type="text" class="form-control" id="department" name="department_id"
                                            value="{{ old('department_id') }}" required>

                                            @foreach ($departments as $dep)
                                            <option value="{{$dep->id}}"
                                                {{old('department_id',$job->department_id)==$dep->id ?"selected":"" }}>
                                                {{$dep->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="occation" class="form-label">
                                            <i class="fas fa-flag mr-2"></i> {{ __("app.jobpostion_name") }}
                                        </label>
                                        <input type="text" class="form-control" id="occation" name="name"
                                            value="{{ old('name',$job->name) }}" required>
                                    </div>


                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check mr-2"></i> {{ __("Edit Department") }}
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