@extends("layouts.master")
@section("title")
{{__("app.create user")}}
@endsection
@section("css")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/css/intlTelInput.css">

<style>
  .iti {
    display: flex !important;
  }

  .hide {
    display: none;
  }

  #employee_data {
    border: 1px solid #cacfe7;
    border-radius: 12px;
    padding-top: 45px;
    padding-bottom: 20px;
    position: relative;
    margin-top: 27px;

  }
</style>
@if(config("app.locale")=='ar')

<style>
  #iti-0__dropdown-content {
    left: 0 !important;
  }

  .eye-icon {
    top: 50%;
    left: 25px;
    font-size: 18px;
    transform: translateY(-50%);
  }

  #phone {
    direction: ltr;
  }

  #employee_data::after {
    content:"{{ __('app.additional_information') }}";
    position: absolute;
    top: -20px;
    right: 14px;
    z-index: 120;
    font-size: 22px;
    background-color: #fff;

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

  #employee_data::after {
    content:"{{ __('app.additional_information') }}";
    position: absolute;
    top: -20px;
    left: 14px;
    z-index: 120;
    font-size: 22px;
    background-color: #fff;

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
                <h4 class="card-title" id="basic-layout-form">{{__("app.create user")}} </h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="card-text">

                  </div>
                  <form class="form" id='form-create' action="{{route('users.store')}}" method="post">

                    @csrf
                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group redAstric">
                            <label for="projectinput1">{{__("app.user name")}}</label>
                            <input type="text" id="projectinput1" class="form-control" placeholder="ex mohamed"
                              name="name" value="{{old('name')}}">
                          </div>
                          @error('name')

                          <div class="text-red-600 text-danger">
                            {{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <div class="form-group redAstric">
                            <label for="projectinput1">{{__("app.fullname")}}</label>
                            <input type="text" id="appinput1" class="form-control" placeholder="ex mohamed"
                              name="fullname" value="{{old('fullname')}}">
                          </div>
                          @error('fullname')

                          <div class="text-red-600 text-danger">
                            {{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6 ">
                          <div class="form-group redAstric">
                            <label for="email">{{__("app.email")}}</label>
                            <input type="email" id="email" class="form-control" placeholder="ex user@email.com"
                              name="email" value="{{old('email')}}">
                          </div>
                          @error('email')

                          <div class="text-red-600 text-danger">
                            {{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <div class="form-group redAstric">
                            <label for="password">{{__("app.status")}}</label>
                            <select class="form-control" name="status">

                              <option value="active" {{(old('status')=='active')?'selected':""}}>
                                {{__("app.active")}}
                              </option>
                              <option value="inactive" {{(old('status')=='inactive')?'selected':""}}>
                                {{__("app.inactive")}}
                              </option>
                            </select>

                            @error('status')

                            <div class="text-red-600 text-danger">
                              {{ $message }}</div>
                            @enderror
                          </div>

                        </div>
                        <div class="col-md-12">
                          <div class="form-group redAstric">
                            <label for="password">{{__("app.password")}}</label>
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
                              <b>{{__('app.Note! Password should:')}}</b> <br>
                              <ul>

                                <li id="length" class="invalid">{{ __('app.password_length') }}</li>
                                <li id="uppercase" class="invalid">{{ __('app.password_uppercase') }}</li>
                                <li id="lowercase" class="invalid">{{ __('app.password_lowercase') }}</li>
                                <li id="number" class="invalid">{{ __('app.password_number') }}</li>
                                <li id="special" class="invalid">{{ __('app.password_special') }}</li>
                              </ul>

                            </div>
                          </div>

                        </div>
                        <div class="col-md-12">
                          <div class="form-group redAstric">
                            <label for="password">{{__("app.password_confirmation")}}</label>
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


                        <div class="col-md-12 ">
                          <div class="form-group redAstric">

                            <label for="password">{{__("app.role")}}</label>
                            <select id="select_roles" class="form-control" name="roles[]">
                              @foreach($roles as $role)
                              <option value="{{ $role->name }}"
                                {{ (in_array($role->name, old('roles',['employee']))) ? 'selected' : '' }}>
                                {{ $role->name }}
                              </option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                    </div>

                </div>
                <div class="form-actions" style="padding: 25px;
                   margin: 10px auto;">
                  <a href="{{route('users.index')}}" class="btn btn-warning mr-1">
                    <i class="ft-x"></i> {{__("app.back")}}
                  </a>
                  <button type="submit" class="btn btn-primary">
                    <i class="la la-check-square-o"></i> {{__("app.save")}}
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
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js"></script>

<script>
  $(document).ready(function() {
    const input = document.querySelector("#phone");
    const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
    const errorMsg = document.querySelector("#error-msg");
    const validMsg = document.querySelector("#valid-msg");
    const form= document.querySelector("#form-create");
    const employee_inputs= $("#employee_data");
    const roles=$('#select_roles');
   // employee_inputs.hide();

 

 
  
  



// if(roles.val()=='employee'){
//   employee_inputs.show();
// }else{
//   employee_inputs.hide();
// }

// roles.on('change',function(){
// if($(this).val()=='employee'){
//   employee_inputs.show();
// }else{
//   employee_inputs.hide();
// }

// });
// input.addEventListener('change', reset);
// input.addEventListener('keyup', reset);

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