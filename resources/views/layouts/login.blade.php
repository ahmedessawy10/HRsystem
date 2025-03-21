<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">

<head>
  <title>@yield('title')</title>
  @include('layouts.header')

  {!!htmlScriptTagJsApi()!!}
  <style>
    body {
      font-family: 'Cairo', sans-serif;
    }

    .valid {
      color: green;
    }

    .invalid {
      color: rgb(217, 90, 73);
    }

    .flexbox-container {
      min-height: 100vh !important;
      height: fit-content !important;
    }

    #password-validate {
      display: none;
    }
  </style>

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



</head>

<body class="vertical-layout vertical-menu 1-column   menu-expanded blank-page blank-page" data-open="click"
  data-menu="vertical-menu" data-col="1-column">

  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        @yield('content')
      </div>
    </div>
  </div>

  @yield("js")
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!-- BEGIN VENDOR JS-->
  <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{asset('app-assets/vendors/js/forms/icheck/icheck.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}" type="text/javascript">
  </script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="{{asset('app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
  <script src="{{asset('app-assets/js/core/app.js')}}" type="text/javascript"></script>
  <!-- END MODERN JS-->


  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        window.copyUser = function (email, pass) {
            document.getElementById("email").value = email;
            document.getElementById("password").value = pass;
        };
    });
   
    
 

  
  @if (Session::has('message'))
  var type = "{{ Session::get('alert-type', 'info') }}"
  switch (type) {
  case 'info':

  toastr.options.timeOut = 10000;
  toastr.info("{{ Session::get('message') }}");
  var audio = new Audio('audio.mp3');
  audio.play();
  break;
  case 'success':

  toastr.options.timeOut = 10000;
  toastr.success("{{ Session::get('message') }}");
  var audio = new Audio('audio.mp3');
  audio.play();

  break;
  case 'warning':

  toastr.options.timeOut = 10000;
  toastr.warning("{{ Session::get('message') }}");
  var audio = new Audio('audio.mp3');
  audio.play();

  break;
  case 'error':

  toastr.options.timeOut = 10000;
  toastr.error("{{ Session::get('message') }}");
  var audio = new Audio('audio.mp3');
  audio.play();

  break;
  }
  @endif
  @if(Session::has('status'))
  var type = "{{ Session::get('status',_('project.something_went_wrong')) }}";
  switch (type) {

  case '{{_("RESET_LINK_SENT")}}':

  toastr.options.timeOut = 10000;
  toastr.success("{{ Session::get('status') }}");
  var audio = new Audio('audio.mp3');
  audio.play();

  break;
  default:

  toastr.options.timeOut = 10000;
  toastr.warning("{{ Session::get('status') }}");
  var audio = new Audio('audio.mp3');
  audio.play();

  break;

  }
  @endif
  $('#password-validate').hide();
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
  $('#eye-password-confirm').click(function() {
  const password = $("#password-confirm");

  if (password.attr('type') === 'text') {
  password.attr('type', 'password');
  $(this).removeClass('ft-eye-off').addClass('ft-eye');
  } else {
  password.attr('type', 'text');
  $(this).removeClass('ft-eye').addClass('ft-eye-off');
  }

  });

  $('#eye-old-password').click(function() {
  const password = $("#old-password");

  if (password.attr('type') === 'text') {
  password.attr('type', 'password');
  $(this).removeClass('ft-eye-off').addClass('ft-eye');
  } else {
  password.attr('type', 'text');
  $(this).removeClass('ft-eye').addClass('ft-eye-off');
  }

  });


  password=$('#password');
  pssword_validate=$('#password-validate');
  pssword_validate.hide();


  const length = $('#length');
  const uppercase = $('#uppercase');
  const lowercase = $('#lowercase');
  const number = $('#number');
  const special = $('#special');
  password.on('keyup', function() {
  pssword_validate.show();
  const passwordValue = password.val();

  length.toggleClass('invalid', passwordValue.length < 12).toggleClass('valid', passwordValue.length>= 12 );

    uppercase.toggleClass('invalid', !/[A-Z]/.test(passwordValue)).toggleClass('valid', /[A-Z]/.test(passwordValue));


    lowercase.toggleClass('invalid', !/[a-z]/.test(passwordValue)).toggleClass('valid', /[a-z]/.test(passwordValue));


    number.toggleClass('invalid', !/[0-9]/.test(passwordValue)).toggleClass('valid', /[0-9]/.test(passwordValue));

    special.toggleClass('invalid', !/[!@#$%^&*()_+{}\[\]:;"'<>,.?~`-]/.test(passwordValue)).toggleClass('valid',
      /[!@#$%^&*()_+{}\[\]:;"'<>,.?~`-]/.test(passwordValue));
        });



        });




  </script>

  {{-- @notify_js
 @notify_render --}}
</body>

</html>