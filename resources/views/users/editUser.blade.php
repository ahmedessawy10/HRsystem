@extends("layouts.master")
@section("title")
{{__("project.edit user")}}
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
    content:"{{ __('project.additional_information') }}";
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
    content:"{{ __('project.additional_information') }}";
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
                <h4 class="card-title" id="basic-layout-form">{{__("project.edit user")}}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="card-text">

                  </div>
                  <form class="form" action="{{route('users.update',$user->id)}}" method="post">
                    @method('put')
                    @csrf
                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group redAstric">
                            <label for="projectinput1">{{__("project.user name")}}</label>
                            <input type="text" id="projectinput1" @if ($user->hasRole('super-admin') && $user->id==1 &&
                            auth()->id()!=1)
                            @disabled(true)
                            @endif
                            class="form-control" placeholder="ex mohamed" name="name"
                            value="{{old('name',$user->name)}}">
                          </div>
                          @error('name')

                          <div class="text-red-600 text-danger">
                            {{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-12">
                          <div class="form-group redAstric">
                            <label for="email">{{__("project.email")}}</label>
                            <input type="email" id="email" class="form-control" placeholder="ex user@email.com"
                              name="email" @if ($user->hasRole('super-admin') && $user->id==1 && auth()->id()!=1)
                            @disabled(true)
                            @endif
                            value="{{old('email',$user->email)}}">
                          </div>
                          @error('email')

                          <div class="text-red-600 text-danger">
                            {{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="password">{{__("project.password")}}</label>
                            <div class="position-relative">
                              <input type="password" id="password" @if ($user->hasRole('super-admin') && $user->id==1 &&
                              auth()->id()!=1)
                              @disabled(true)
                              @endif
                              class="form-control" name="password" value="{{old('password')}}">
                              <i id="eye-password" class=" eye-icon  ft-eye position-absolute "></i>


                            </div>

                            <div class="col-md-12">
                              <div class="form-group redAstric">
                                <label for="password">{{__("project.status")}}</label>
                                <select class="form-control" name="status"
                                  {{($user->hasRole('super-admin') && $user->id==1)?"readonly":" "}}>

                                  <option value="active" {{(old('status',$user->status)=='active')?'selected':""}}>
                                    {{__("project.active")}}
                                  </option>
                                  <option value="inactive" {{(old('status',$user->status)=='inactive')?'selected':""}}>
                                    {{__("project.inactive")}}
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

                                <label for="password">{{__("project.roles")}}</label>

                                <select id="select_roles" class="form-control" name="roles[]"
                                  {{($user->hasRole('super-admin') && $user->id==1)?"readonly":" "}}>
                                  @foreach($roles as $role)

                                  <option value="{{ $role->name }}"
                                    {{ (in_array($role->name, old('roles', $userRoles->toArray()))) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                  </option>
                                  @endforeach
                                </select>
                                @error('roles')

                                <div class="text-red-600 text-danger">
                                  {{ $message }}</div>
                                @enderror
                              </div>
                            </div>





                          </div>


                        </div>
                        <div class="form-actions">
                          <a href="{{route('users.index')}}" class="btn btn-warning mr-1">
                            <i class="ft-x"></i>{{__("project.back")}}
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

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js"></script>
<script>
  $(document).ready(function() {


const showError = (msg) => {
  input.classList.add("error");
  errorMsg.innerHTML = msg;
  errorMsg.classList.remove("hide");
};

input.addEventListener('keyup', () => {
  reset();
  if (!input.value.trim()) {
    showError("Required");
  } else if (iti.isValidNumber()) {
    validMsg.classList.remove("hide");
  } else {
    const errorCode = iti.getValidationError();
    const msg = errorMap[errorCode] || "Invalid number";
    showError(msg);
  }
});

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



});
</script>
@endsection