@extends("layouts.master")

@section("title", "Add New Career")

@section("css")
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
        color: #333;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(45deg, #0ccaf0, #00a3e0);
        color: white;
        text-align: center;
        border-radius: 12px 12px 0 0;
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
        border-color: #0ccaf0;
        box-shadow: 0 0 0 0.2rem rgba(12, 202, 240, 0.25);
    }

    form .btn {
        color: #fff;
        background-color: #0ccaf0;
        border-radius: 8px;
    }

    form .btn:hover {
        background-color: #00a3e0 !important;
    }

    .icon-button {
        background: none;
        border: none;
        color: #0ccaf0;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .icon-button:hover {
        color: #00a3e0;
    }
</style>
@endsection

@section("content")
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="bi bi-calendar-check me-2"></i> {{__('app.add new career')}}</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <form action="{{ route('careers.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="department_id">{{__('app.department')}}</label>
                                            <select name="department_id" id="department_id" class="form-select">
                                                @foreach($departments as $department)
                                                <option {{ old("department") == $department->id ? "selected" : "" }} value="{{$department->id}}">{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{__("app.title")}}</label>
                                            <input type="text" name="title" required class="form-control" id="title" value="{{ old("title") }}" autofocus placeholder="{{__('app.title')}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="status">{{__('app.status')}}</label>
                                            <select name="status" id="status" class="form-select">
                                                @foreach(careerStatus() as $status)
                                                <option value="{{$status}}" {{ old("status") == $status ? "selected" : "" }}>{{$status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description">{{__('app.description')}}</label>
                                            <textarea name="description" id="description" class="form-control" rows="5">{{ old("description") }}</textarea>
                                        </div>
                                        <div class="d-flex justify-content-center mt-4">
                                            <button type="submit" class="btn btn-primary fs-5">
                                                <i class="fa fa-save me-2"></i> Save
                                            </button>
                                        </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
