<link rel=" shortcut icon" href="{{asset('uploads/'.$appSetting->favicon)}}">
<link rel="apple-touch-icon" type="image/x-icon" href="{{asset('uploads/'.$appSetting->favicon)}}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
<link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">

@if(config('app.locale')=='ar')
<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/vendors.css')}}">
<link rel="stylesheet" type="text/css"
    href="{{asset('app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css') }}">


<!-- END VENDOR CSS-->
<!-- BEGIN MODERN CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/app.css')}}">

<!-- END MODERN CSS-->
<!-- BEGIN Page Level CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/core/colors/palette-gradient.css')}}">


@else
<!-- BEGIN VENDOR CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/vendors.css')}}">
<link rel="stylesheet" type="text/css"
    href="{{asset('app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css') }}">


<!-- END VENDOR CSS-->
<!-- BEGIN MODERN CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/app.css')}}">
<!-- END MODERN CSS-->
<!-- BEGIN Page Level CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/colors/palette-gradient.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/colors/palette-gradient.css')}}">

@endif
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/fonts/simple-line-icons/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/toggle/switchery.min.css') }}">