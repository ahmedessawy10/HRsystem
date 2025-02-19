@extends('layouts.login')
@section('title',__("project.login"))

@section('content')
<section class="flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-md-4 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                    <div class="card-title text-center">
                        <div class="p-1">
                            <img style="width:200px" src="{{asset('uploads/'.$appSetting->logo)}}" alt="LOGO" />

                        </div>
                    </div>

                </div>

                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal form-simple" action="{{route('login')}}" method="post" novalidate>
                            @csrf
                            <fieldset class="form-group position-relative has-icon-left mb-2">
                                <input type="text" name="email" class="form-control form-control-lg input-lg"
                                    value="{{old('email')}}" id="email" placeholder="{{__('project.enter email')}}">
                                <div class="form-control-position">
                                    <i class="ft-user"></i>
                                </div>
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="password" name="password" id="password"
                                    class="form-control form-control-lg input-lg " id="user-password"
                                    value="{{old('password')}}" placeholder="{{__('project.enter password')}}">

                                <div class="form-control-position">
                                    <i class="la la-key"></i>
                                </div>

                                <i id="eye-password" class=" eye-icon  ft-eye position-absolute"></i>

                            </fieldset>

                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <div class="form-group row">
                                <div class="col-md-6 col-12 text-center text-md-left">

                                    {!!htmlFormSnippet()!!}
                                    @if($errors->has('g-recaptcha-response'))

                                    <span class="text-danger">{{$errors->first('g-recaptcha-response')}}</span>

                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6 col-md-12 text-center text-md-left ">

                                    <fieldset>
                                        <input type="checkbox" name="remember_me" id="remember-me"
                                            class="chk-remember text-3">
                                        <label for="remember-me"> {{__('remember me')}}</label>
                                    </fieldset>

                                </div>

                                <div>
                                    <fieldset class="col-6 col-md-12 text-center text-md-left ">
                                        <a href="{{route('password.request')}}"
                                            rel="noopener noreferrer">{{__('Forgot your password?')}}</a>
                                    </fieldset>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i>
                                {{__("login")}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection