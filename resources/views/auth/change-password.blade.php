@extends('layouts.login')
@section('title',__("project.change_password"))

@section('content')
<section class="flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-md-4 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                    <div class="card-title text-center">
                        <div class="p-1">
                            <img style="width:200px" src="{{asset('app-assets/images/logo.png')}}" alt="LOGO" />

                        </div>
                    </div>
                </div>

                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal form-simple" action="{{route('changePassword')}}" method="post"
                            novalidate>

                            @csrf

                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="password" name="old_password" id="old-password"
                                    class="form-control form-control-lg input-lg " id="user-old-password"
                                    value="{{old('old_password')}}" placeholder="{{__('project.enter old-password')}}">

                                <div class="form-control-position">
                                    <i class="la la-key"></i>
                                </div>
                                <i id="eye-old-password" class="eye-icon  ft-eye position-absolute "></i>


                            </fieldset>
                            @error('old-password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="password" name="password" id="password"
                                    class="form-control form-control-lg input-lg " id="user-password"
                                    value="{{old('password')}}" placeholder="{{__('project.enter password')}}">

                                <div class="form-control-position">
                                    <i class="la la-key"></i>
                                </div>
                                <i id="eye-password" class="eye-icon  ft-eye position-absolute "></i>


                            </fieldset>
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <div class="form-text text-muted" id='password-validate'>
                                <b>{{__('project.Note! Password should:')}}</b> <br>
                                <ul>

                                    <li id="length" class="invalid">{{ __('project.password_length') }}</li>
                                    <li id="uppercase" class="invalid">{{ __('project.password_uppercase') }}</li>
                                    <li id="lowercase" class="invalid">{{ __('project.password_lowercase') }}</li>
                                    <li id="number" class="invalid">{{ __('project.password_number') }}</li>
                                    <li id="special" class="invalid">{{ __('project.password_special') }}</li>
                                </ul>

                            </div>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="password" name="password_confirmation" id="password-confirm"
                                    class="form-control form-control-lg input-lg " id="password-confirm"
                                    value="{{old('password_confirmation')}}"
                                    placeholder="{{__('project.enter_confirm_password')}}">

                                <div class="form-control-position">
                                    <i class="la la-key"></i>
                                </div>
                                <i id="eye-password-confirm" class=" eye-icon  ft-eye position-absolute "></i>
                                @error('password_confirmation')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </fieldset>

                            <button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i>
                                {{__("project.change_password")}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection