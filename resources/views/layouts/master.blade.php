<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
        @yield("title")
    </title>

    @include('layouts.header')
    @yield("css")
    <style>
        body {
            font-family: "Cairo", sans-serif;
        }

        #loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100vh;
            /* semi-transparent background */
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1100;
            /* ensure the loader appears on top */
        }

        #loader img {
            width: 20%;
            /* adjust size as needed */
            height: auto;
        }

        .redAstric::before {
            content: "*";
            color: red;
        }

        .valid {
            color: green;
        }

        .invalid {
            color: rgb(217, 90, 73);
        }
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-col="2-columns">


    <div id="loader">
        <img src="{{asset('app-assets/images/loader.gif')}}" alt="Loading...">
    </div>
    @include('layouts.nav')
    @include('layouts.sidebar')
    @yield("content")

    @include('layouts.footer')

    <!-- BEGIN VENDOR JS-->
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <script src="{{asset('app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js')}}" type="text/javascript">
    </script>
    <!-- BEGIN MODERN JS-->
    <script src="{{asset('app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}" type="text/javascript"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @yield("js")

    <script>
        $(window).on('load', function(){
          setTimeout(removeLoader, 1000); //wait for page load PLUS two seconds.
        });
        function removeLoader(){
            $( "#loader" ).fadeOut(500, function() {
              // fadeOut complete. Remove the loading div
              $("#loader").remove(); //makes page more lightweight 
          });   
        }
          
    </script>


    @if (Session::has('messages'))
    <script>
        $(document).ready(function() {
            var messages = @json(Session::get('messages'));
            var type = "{{ Session::get('alert-type', 'info') }}";

            messages.forEach(function(message) {
                toastr.options.timeOut = 10000; // Set timeout
                var audio = new Audio('audio.mp3');
                audio.play();

                switch (type) {
                    case 'info':
                        toastr.info(message);
                        break;
                    case 'success':
                        toastr.success(message);
                        break;
                    case 'warning':
                        toastr.warning(message);
                        break;
                    case 'error':
                        toastr.error(message);
                        break;
                }
            });
        });
    </script>
    @endif

    <script>
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
      
        length.toggleClass('invalid', passwordValue.length < 12).toggleClass('valid', passwordValue.length >= 12 );

        uppercase.toggleClass('invalid', !/[A-Z]/.test(passwordValue)).toggleClass('valid', /[A-Z]/.test(passwordValue));


        lowercase.toggleClass('invalid', !/[a-z]/.test(passwordValue)).toggleClass('valid', /[a-z]/.test(passwordValue));

      
        number.toggleClass('invalid', !/[0-9]/.test(passwordValue)).toggleClass('valid', /[0-9]/.test(passwordValue));

        special.toggleClass('invalid', !/[!@#$%^&*()_+{}\[\]:;"'<>,.?~`-]/.test(passwordValue)).toggleClass('valid', /[!@#$%^&*()_+{}\[\]:;"'<>,.?~`-]/.test(passwordValue));
    });
    </script>

</body>

</html>