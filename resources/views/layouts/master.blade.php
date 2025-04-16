<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>
        @yield("title")
    </title>

    @include('layouts.header')
    @yield("css")
    <style>
        body {
            font-family: "Cairo", sans-serif;
        }

        .bg-info {
            background-color: #1e9ff2 !important;
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

        .navigation li a {
            font-size: 1.2rem;
            font-weight: bold;
        }

        :root {
            --bs-primary: #0ccaf0;
        }

        .btn-primary {
            background-color: #1E9FF2 !important;
            border-color: #1E9FF2 !important;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #178fd8 !important;
            border-color: #178fd8 !important;
        }

        .text-primary {
            color: #1E9FF2 !important;
        }

        .bg-primary {
            background-color: #1E9FF2 !important;
        }

        .btn-outline-primary {
            border-color: #1E9FF2 !important;
            background-color: transparent !important;
            color: #1E9FF2 !important;

        }

        .btn-outline-primary:hover,
        .btn-outline-primary:focus {
            background-color: #1E9FF2 !important;
            color: #fff !important;
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="{{asset('app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js')}}" type="text/javascript">
    </script>
    <!-- BEGIN MODERN JS-->
    <script src="{{asset('app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}" type="text/javascript"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    @yield("js")

    <script>
        $(window).on('load', function(){
          setTimeout(removeLoader, 50); //wait for page load PLUS two seconds.
        });
        function removeLoader(){
            $( "#loader" ).fadeOut(100, function() {
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
    @if (!empty(Session::all()))
    @foreach (Session::all() as $type => $message)
    @if (in_array($type, ['success', 'warning', 'info', 'error']))
    <script>
        $(document).ready(function() {
                    var message = "{{ addslashes($message) }}";
                    var type = "{{ $type }}";

                    toastr.options.timeOut = 10000;

                    // Play audio if available
                    // var audio = new Audio('audio.mp3');
                    // audio.play().catch(function(error) {
                    //     console.error("Audio playback failed: ", error);
                    // });

                    // Display toastr notification based on type
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
    </script>
    @endif
    @endforeach
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