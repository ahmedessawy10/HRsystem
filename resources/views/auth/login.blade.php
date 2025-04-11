@extends('layouts.login')
@section('title',__("project.login"))

@section('content')
<section class="flexbox-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 col-sm-10">
                <div class="card shadow-sm border-light">
                    <div class="card-header text-center bg-transparent border-0">
                        <img style="width: 150px;" src="{{ asset('uploads/'.$appSetting->logo) }}" alt="LOGO">
                    </div>

                    <div class="card-body">
                        <form action="{{ route('login') }}" method="POST" id="loginForm">
                            @csrf

                            <div class="mb-1 position-relative">
                                <label for="email" class="form-label">{{ __('project.enter email') }}</label>
                                <input type="text" name="email" id="email" class="form-control ps-4"
                                    value="{{ old('email') }}" placeholder="{{ __('project.enter email') }}">
                                <i class="position-absolute translate-middle-y me-3 ft-user" style="top:65%;"></i>
                                @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-1 position-relative">
                                <label for="password" class="form-label">{{ __('project.enter password') }}</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="{{ __('project.enter password') }}">
                                <i id="eye-password" style="top:69%"
                                    class="eye-icon position-absolute top-50 end-0 translate-middle-y me-3 ft-eye"
                                    style="cursor: pointer;"></i>
                                @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-1">
                                {!! htmlFormSnippet() !!}
                                @if($errors->has('g-recaptcha-response'))
                                <div class="text-danger small">{{ $errors->first('g-recaptcha-response') }}</div>
                                @endif
                            </div>

                            <div class=" form-check">
                                <input type="checkbox" name="remember_me" id="remember-me" class="form-check-input">
                                <label class="form-check-label" for="remember-me">{{ __('remember me') }}</label>
                            </div>

                            <div class="">
                                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                            </div>

                            <button type="submit" class="btn btn-info w-100">
                                <i class="ft-unlock"></i> {{ __("login") }}
                            </button>
                        </form>

                        {{-- Demo Accounts --}}
                        <div class="mt-4">
                            <h5 class="text-center mb-1">{{ __('Demo Accounts') }}</h5>
                            <div class="d-grid gap-2 ">
                                <button class="btn btn-outline-primary"
                                    onclick="copyUser('admin@gmail.com', '123456')">Login as Admin</button>
                                <button class="btn btn-outline-primary"
                                    onclick="copyUser('hrManger@gmail.com', '123456')">Login as HR</button>
                                <button class="btn btn-outline-primary"
                                    onclick="copyUser('employee@gmail.com', '123456')">Login as Employee</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection