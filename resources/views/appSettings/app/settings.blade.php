@extends("layouts.master")

@section("title")
{{ __("app.appSettings") }}
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
                                    <i class="fas fa-setting-alt mr-2"></i>{{ __("app.appsettings") }}

                                </h2>

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

                                        <form action="{{route('appSettings.store')}}" method="post"
                                            onsubmit="return checkSubmit(event)" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="name" class="form-label">{{__('app.name')}}</label>

                                                    <input type="text" class="form-control checknumber" id="name"
                                                        name="name" placeholder="2 hours"
                                                        value="{{old('name',$appSetting->name)}}">
                                                </div>

                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="language"
                                                        class="form-label">{{ __('app.language') }}</label>

                                                    <select name="language" class="form-select" id="language">
                                                        {{-- @php
                                                        $langauges=LaravelLocalization::getSupportedLocales() ;
                                                        @endphp
                                                        @foreach( $langauges as
                                                        $localeCode=> $properties)
                                                        <option value="{{$localeCode}}"
                                                        {{ old('language', $appSetting->language) == $localeCode ? 'selected' : '' }}>
                                                        {{  $properties['name'] }}
                                                        </option>
                                                        @endforeach --}}
                                                        <option value="ar"
                                                            {{ old('language', $appSetting->language) == 'ar' ? 'selected' : '' }}>
                                                            arabic
                                                        </option>
                                                        <option value="en"
                                                            {{ old('language', $appSetting->language) == 'en' ? 'selected' : '' }}>
                                                            english
                                                        </option>

                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <h4 for="logo" class="form-label">{{__('app.logo')}}</h4>
                                                    <label for="logo" class="form-label"><img
                                                            style="max-width:100%;height:150px"
                                                            src="{{asset("uploads/".$appSetting->logo)}}"
                                                            alt=""></label>

                                                    <input type="file" class="form-control checknumber" id="add"
                                                        name="logo" value="{{old('favicon',$appSetting->logo)}}">

                                                </div>
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <h4 for="logo" class="form-label">{{__('app.favicon')}}</h4>
                                                    <label for="favicon" class="form-label"><img style=""
                                                            src="{{asset("uploads/".$appSetting->favicon)}}"
                                                            alt=""></label>
                                                    <div class="input-group mb-1">
                                                        <input type="file" class="form-control checknumber" id="add"
                                                            name="favicon" placeholder="2 hours"
                                                            value="{{old('favicon',$appSetting->favicon)}}">

                                                    </div>

                                                </div>

                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="name" class="form-label">{{__('app.time_zone')}}</label>
                                                    <select name="time_zone" class="form-select" id="timezone">
                                                        @foreach (getTimezone() as $timezone )
                                                        <option value="{{$timezone}}"
                                                            {{old('time_zone',$appSetting->time_zone)== $timezone?'selected':"" }}>
                                                            {{$timezone}}</option>

                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="date_format"
                                                        class="form-label">{{__('app.dateformat')}}</label>
                                                    <select name="date_format" class="form-select" id="date_format">
                                                        @foreach (getDateformat() as $dateformat )
                                                        <option value="{{$dateformat}}"
                                                            {{old('date_format',$appSetting->date_format)== $dateformat?'selected':"" }}>
                                                            {{$dateformat}}</option>

                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="name"
                                                        class="form-label">{{__('app.timeformat')}}</label>
                                                    <select name="time_format" class="form-select" id="time_format">
                                                        @foreach (getTimeformat() as $timeformat )
                                                        <option value="{{$timeformat}}"
                                                            {{old('time_format',$appSetting->time_format)== $timeformat?'selected':"" }}>
                                                            {{$timeformat}}</option>

                                                        @endforeach
                                                    </select>


                                                </div>





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
    function checkSubmit(event) {
event.preventDefault();

let flag = true;

// التحقق من الحقول الرقمية
// let inputs = document.querySelectorAll('.checknumber');
// inputs.forEach((input) => {
// let value = input.value.trim();
// if (value === "" || isNaN(value)) {
// alert("يرجى إدخال قيمة رقمية صحيحة في جميع الحقول!");
// flag = false;
// }
// });

// التحقق من اختيار يومين على الأقل


// إرسال النموذج إذا كان كل شيء صحيحًا
if (flag) {
event.target.submit();
}
}

</script>
@endsection