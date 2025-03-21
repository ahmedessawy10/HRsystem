@extends("layouts.master")
@section("title", "Add New Attendance")

@section("css")

<style>
    /* body {
        background-color: #f8f9fa;
        color: #333;
    } */

    /* .attend .card {
        width: 50%;
        margin: auto;
        border-radius: 8px;
        background: #ffffff;
        border: none;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .attend .card-header {
        background: linear-gradient(45deg, #2c3e50, #34495e);
        color: white;
        text-align: center;
        border-radius: 8px 8px 0 0;
        padding: 1.5rem;
    }

    .attend .card-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .attend .form-control {
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    } */

    form .btn {
        color: #fff;
        background-color: #1E9FF2;
    }

    form .btn:hover {
        color: #808080;
        background-color: #1E9FF2 !important;
    }
</style>
@endsection

@section("content")
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">

            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="bi bi-calendar-check me-2"></i> Add New Attendance</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
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

                                    <form action="{{ route('attendance.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-1 py-2">
                                            <label for="user">{{__('app.user')}}</label>
                                            <select name="user_id" id="user" class="form-select">
                                                @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->fullname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Date</label>
                                            <input type="date" name="date" class="form-control" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">{{__("app.timein")}}</label>
                                                    <input type="time" name="time_in" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">{{__("app.timeout")}}</label>
                                                    <input type="time" name="time_out" class="form-control">
                                                </div>
                                            </div>
                                        </div>


                                        {{-- <div class="mb-3">
                                            <label class="form-label">{{__("app.lateMinutes")}}</label>
                                        <input type="number" name="late_minutes" class="form-control" required>
                                </div> --}}
                                {{-- <div class="mb-3">
                                            <label class="form-label">{{__("app.extraMinutes")}}</label>
                                <input type="number" name="extra_minutes" class="form-control" required>
                            </div> --}}
                            <div class="d-flex justify-content-center mt-4 ">
                                <button type="submit" class="btn  fs-5">
                                    <i class="fa fa-save me-2 "></i> Save
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



@endsection