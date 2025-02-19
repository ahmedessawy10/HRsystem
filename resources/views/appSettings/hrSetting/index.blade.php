@extends("layouts.master")

@section("title")
{{ __("app.hrsettings") }}
@endsection

@section("css")
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f4f8;
        color: #333;
    }

    .card {
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
    }

    .card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        padding: 20px;
        background: #f0f4f8;
        color: #fff;
        font-size: 22px;
        font-weight: 700;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-body {
        padding: 30px;
    }

    /* Table Styles */
    .table th,
    .table td {
        padding: 15px;
        text-align: center;
        font-size: 14px;
        font-weight: 500;
    }

    .table-hover tbody tr:hover {
        background-color: #e3f2fd;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9fbff;
    }

    .thead-custom th {
        background: #1da1f2;
        color: #fff;
        font-weight: 600;
    }

    /* Search Input */
    #search {
        border-radius: 25px;
        padding: 12px 20px;
        font-size: 15px;
        border: 1px solid #ccc;
        background-color: #fff;
        width: 100%;
        margin-bottom: 20px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    #search:focus {
        border-color: #1da1f2;
        box-shadow: 0 0 8px rgba(29, 161, 242, 0.3);
        outline: none;
    }

    /* Buttons & Actions */
    .btn-light {
        background-color: #1da1f2;
        color: #fff;
        border-radius: 8px;
        padding: 10px 16px;
        transition: background-color 0.3s ease;
    }

    .btn-light:hover {
        background-color: #007bff;
    }

    /* Dropdown Menu Styles */
    .dropdown .dropdown-toggle {
        background: transparent;
        border: none;
        color: #333;
        font-size: 18px;
        padding: 4px;
    }

    .dropdown .dropdown-toggle:focus {
        outline: none;
        box-shadow: none;
    }

    .dropdown-menu {
        min-width: 140px;
    }

    .dropdown-item {
        font-size: 14px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dropdown-item:hover {
        background: #1da1f2;
        color: #fff;
    }

    /* Pagination Styles */
    .pagination {
        justify-content: center;
        margin-top: 20px;
    }

    .pagination .page-link {
        border-radius: 50px;
        padding: 8px 16px;
        margin: 0 5px;
        background-color: #e9ecef;
        color: #1da1f2;
        border: none;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .pagination .page-link:hover {
        background-color: #1da1f2;
        color: #fff;
    }

    .pagination .active .page-link {
        background-color: #1da1f2;
        color: #fff;
    }

    /* Alert Styles */
    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 16px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-left: 5px solid #1da1f2;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
        border-left: 5px solid #1da1f2;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        border-left: 5px solid #ffc107;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 5px solid #dc3545;
    }

    .alert .close {
        margin-left: auto;
        font-size: 20px;
        cursor: pointer;
    }

    @media (max-width: 767px) {
        .table-responsive {
            margin-bottom: 20px;
        }

        #search {
            width: 100%;
        }
    }
</style>
@endsection

@section("content")
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <section id="holiday-list">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="card-title m-0 fs-2">
                                    <i class="fas fa-setting-alt mr-2"></i>{{ __("app.hrsettings") }}

                                </h2>


                                <div>
                                    {{-- <a href="{{ route('holiday.report') }}" class="btn btn-info mr-2"
                                    data-toggle="tooltip" data-placement="top" title="View Holiday Report">
                                    <i class="fas fa-file-alt"></i>
                                    </a> --}}

                                    {{-- <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="fas fa-plus"></i>
                                    </button> --}}
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <!-- Alert Messages -->
                                    @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-times-circle"></i> {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    @if(session('warning'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    @if(session('info'))
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <i class="fas fa-info-circle"></i> {{ session('info') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif

                                    <!-- Search Input -->

                                    <div>

                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        <form action="{{route('hrSettings.store')}}" method="post"
                                            onsubmit="return checkSubmit(event)">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="discount"
                                                        class="form-label">{{__('app.salary_discount')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control checknumber"
                                                            id="discount" name="discount" placeholder="2 hours"
                                                            value="{{old('discount',$hrSetting->discount)}}">
                                                        <span class="input-group-text">{{__('app.hours')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="overtime"
                                                        class="form-label">{{__('app.salary_add')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control checknumber" id="add"
                                                            name="overtime" placeholder="2 hours"
                                                            value="{{old('overtime',$hrSetting->overtime)}}">
                                                        <span class="input-group-text">{{__('app.hours')}}</span>
                                                    </div>

                                                </div>
                                            </div>
                                            <h3 class="mb-2">{{__("app.work_day")}}</h3>
                                            <div class="row">
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="start_time"
                                                        class="form-label">{{__('app.time_start')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="time" class="form-control checknumber"
                                                            id="start_time" name="start_time" placeholder=""
                                                            value="{{old('start_time',$hrSetting->start_time)}}">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-clock"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="end_time"
                                                        class="form-label">{{__('app.time_end')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="time" class="form-control checknumber"
                                                            id="start_time" name="end_time" placeholder=""
                                                            value="{{old('end_time',$hrSetting->end_time)}}">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-clock"></i></span>
                                                    </div>

                                                </div>
                                            </div>

                                            @php
                                            $weekdays = [
                                            0 => __('app.saturday'),
                                            1 => __('app.sunday'),
                                            2 => __('app.monday'),
                                            3 => __('app.tuesday'),
                                            4 => __('app.wednesday'),
                                            5 => __('app.thursday'),
                                            6 => __('app.friday'),
                                            ];
                                            $selectedHolidays = old('holidays', json_decode($hrSetting->holidays) ??
                                            []);
                                            @endphp

                                            <h3 class="mb-6">{{__("app.holidays")}}</h3>
                                            @foreach ($weekdays as $key => $day)
                                            <div class="form-check" style="font-size:18px;margin:20px">
                                                <input class="form-check-input weekday-checkbox" type="checkbox"
                                                    name="holidays[]" value="{{ $key }}" id="check-{{ $key }}"
                                                    {{ in_array($key, $selectedHolidays ) ? 'checked' : '' }}>
                                                <label class="form-check-label mx-1"
                                                    for="check-{{ $key }}">{{ $day }}</label>
                                            </div>
                                            @endforeach



                                            <div class="d-flex justify-content-center ">
                                                <button type="submit"
                                                    class="btn btn-primary text-center fs-4">{{__('app.save')}}</button>
                                            </div>


                                        </form>

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




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">{{__('app.department_name')}}</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="department">

                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type=" submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section("js")
<script>
    // Search filter functionality
//   document.getElementById('search').addEventListener('keyup', function() {
//     let value = this.value.toLowerCase();
//     document.querySelectorAll("tbody tr").forEach(row => {
//       row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
//     });
//   });

  // Initialize tooltips (using Bootstrap)
//   $(function () {
//     $('[data-toggle="tooltip"]').tooltip();
//   });

function checkSubmit(event) {
    event.preventDefault();
    
    let flag = true;

    // التحقق من الحقول الرقمية
    // let inputs = document.querySelectorAll('.checknumber');
    // inputs.forEach((input) => {
    //     let value = input.value.trim();
    //     if (value === "" || isNaN(value)) {
    //         alert("يرجى إدخال قيمة رقمية صحيحة في جميع الحقول!");
    //         flag = false;
    //     }
    // });

    // التحقق من اختيار يومين على الأقل
    let checkedDays = document.querySelectorAll('.weekday-checkbox:checked').length;
    if (checkedDays < 2) {
        alert("يجب اختيار يومين على الأقل كعطلة!");
        flag = false;
    }

    // إرسال النموذج إذا كان كل شيء صحيحًا
    if (flag) {
        event.target.submit();
    }
}

</script>
@endsection