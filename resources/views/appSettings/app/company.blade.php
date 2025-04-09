@extends("layouts.master")

@section("title")
{{ __("app.companys") }}
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

    button[type="submit"] {
        background-color: #1da1f2 !important;
        color: #fff !important;
        border: none !important;
        padding: 10px 20px !important;
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
                                    <i class="fas fa-setting-alt mr-2"></i>{{ __("app.company setting") }}

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

                                        <form action="{{route('companySetting.store')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="name"
                                                        class="form-label">{{__('app.company name')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control checknumber" id="name"
                                                            name="name" placeholder="hr system"
                                                            value="{{old('name',$company->name)}}">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-building"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="email"
                                                        class="form-label">{{__('app.company email')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control checknumber" id="add"
                                                            name="email" placeholder="2 hours"
                                                            value="{{old('email',$company->email)}}">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-envelope"></i></span>

                                                    </div>

                                                </div>
                                            </div>
                                            {{-- <h3 class="mb-2">{{__("app.work_day")}}</h3> --}}
                                            <div class="row">
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="start_time"
                                                        class="form-label">{{__('app.company phone')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control checknumber" id="phone"
                                                            name="phone" placeholder=""
                                                            value="{{old('phone',$company->phone)}}">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-phone"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="end_time"
                                                        class="form-label">{{__('app.company address')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control checknumber" id="address"
                                                            name="address" placeholder=""
                                                            value="{{old('address',$company->address)}}">
                                                        <span class="input-group-text"><i class="fa fa-map"></i></span>
                                                    </div>

                                                </div>
                                            </div>



                                            <h3 class="mb-2">{{__("app.company location")}}</h3>
                                            <div class="row">
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="latitude"
                                                        class="form-label">{{__('app.company latitude')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control checknumber"
                                                            id="latitude" name="latitude" placeholder=""
                                                            value="{{old('latitude',$company->latitude)}}">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-location-arrow"></i>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="longitude"
                                                        class="form-label">{{__('app.company longitude')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control checknumber"
                                                            id="longitude" name="longitude" placeholder=""
                                                            value="{{old('longitude',$company->longitude)}}">
                                                        <span class="input-group-text"><i
                                                                class="fa fa-location-arrow"></i></span>
                                                    </div>

                                                </div>

                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="radius"
                                                        class="form-label">{{__('app.company radius')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control checknumber" id="radius"
                                                            name="radius" placeholder=""
                                                            value="{{old('radius',$company->radius)}}">
                                                        <span class="input-group-text"><i
                                                                class="fa  fa-radiation"></i></span>
                                                    </div>

                                                </div>
                                                <div class="col-12 col-lg-6 mb-1 fs-4">
                                                    <label for="city"
                                                        class="form-label">{{__('app.company city')}}</label>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control checknumber" id="city"
                                                            name="city" placeholder=""
                                                            value="{{old('city',$company->city)}}">
                                                        <span class="input-group-text"><i class="fa fa-city"></i></span>
                                                    </div>

                                                </div>
                                            </div>





                                            <div class="d-flex justify-content-center ">
                                                <button type="submit"
                                                    class="btn text-center fs-4">{{__('app.save')}}</button>
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



@endsection

@section("js")
<script>

</script>
@endsection