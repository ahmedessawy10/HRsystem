@extends("layouts.master")
@section("title")
{{__("project.edit profile")}}
@endsection
@section("css")
@if(config("app.locale")=='ar')

<style>
  .eye-icon {
    top: 50%;
    left: 25px;
    font-size: 18px;
    transform: translateY(-50%);
  }
</style>

@else
<style>
  .eye-icon {
    top: 50%;
    right: 25px;
    font-size: 18px;
    transform: translateY(-50%);
  }
</style>
@endif
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
            <div class="card" style="">
              <div class="card-header">
                <h4 class="card-title" id="basic-layout-form">{{__("project.edit profile")}} </h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="card-text">

                  </div>
                  <form class="form" action="{{route('admin.user.updateProfile')}}" method="post">

                    @csrf
                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group redAstric ">
                            <label for="projectinput1">{{__("project.user name")}}</label>
                            <input type="text" id="projectinput1" class="form-control" placeholder="ex mohamed"
                              name="name" value="{{old('name',$user->name)}}" @can('profile name edit') required @else
                              disabled @endcan>
                          </div>
                          @error('name')

                          <div class="text-red-600 text-danger">
                            {{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-12 ">
                          <div class="form-group redAstric ">
                            <label for="email">{{__("project.email")}}</label>
                            <input type="email" id="email" class="form-control" placeholder="ex user@email.com"
                              name="email" value="{{old('email',$user->email)}}" @can('profile email edit') required
                              @else disabled @endcan>
                          </div>
                          @error('email')

                          <div class="text-red-600 text-danger">
                            {{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-12">
                          <div class="form-group ">
                            <label for="password">{{__("project.password")}}</label>
                            <div class="position-relative">
                              <input type="password" id="password" class="form-control" name="password"
                                value="{{old('password')}}">
                              <i id="eye-password" class=" eye-icon  ft-eye position-absolute "></i>
                            </div>
                            @error('password')

                            <div class="text-red-600 text-danger">
                              {{ $message }}</div>
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
                          </div>

                        </div>
                        <div class="col-md-12">
                          <div class="form-group ">
                            <label for="password">{{__("project.password_confirmation")}}</label>
                            <div class="position-relative">
                              <input type="password" id="password_confirmation" class="form-control"
                                name="password_confirmation" value="{{old('password_confirmation')}}">
                              <i id="confirm" class="eye-icon ft-eye position-absolute top-50 left-0"></i>
                            </div>
                          </div>
                          @error('password_confirmation')

                          <div class="text-red-600 text-danger">
                            {{ $message }}</div>
                          @enderror
                        </div>

                      </div>

                    </div>
                    <div class="form-actions">
                      <a href="{{route('admin.dashboard')}}" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> {{__("project.back")}}
                      </a>
                      <button type="submit" class="btn btn-primary">
                        <i class="la la-check-square-o"></i> {{__("project.save")}}
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

<script>
  $(document).ready(function() {
  
    $('#eye-password').click(function() {
      const password = $("#password");
      
      if (password.attr('type') === 'text') {
        password.attr('type', 'password');
        $(this).removeClass('ft-eye-off').addClass('ft-eye');
      } else {
        password.attr('type', 'text');
        $(this).removeClass('ft-eye').addClass('ft-eye-off');
      }
      
    });
    $('#confirm').click(function() {
      const password = $("#password_confirmation");
      
      if (password.attr('type') === 'text') {
        password.attr('type', 'password');
        $(this).removeClass('ft-eye-off').addClass('ft-eye');
      } else {
        password.attr('type', 'text');
        $(this).removeClass('ft-eye').addClass('ft-eye-off');
      }
      
    });
  
  });
</script>
@endsection