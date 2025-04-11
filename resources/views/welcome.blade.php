<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/70">

    <header class="bg-white dark:bg-gray-900 py-4 px-6 shadow">
        <nav class="flex flex-row md:items-center justify-between  gap-4">
            <!-- Logo -->
            <div class="flex  md:justify-start md:w-1/3">
                <img src="{{ asset('uploads/' . $appSetting->logo) }}" class="w-48 h-auto" alt="Logo">

            </div>

            <button class="dark:text-white  px-2 text-2xl max-md:inline-block md:hidden" id="menu-toggle">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Links -->

            <div class="md:relative fixed  flex max-md:top-[84px] w-[100vh] max-md:left-[50%] max-md:translate-x-[-50%] max-md:bg-slate-200  dark:max-md:bg-gray-800 py-3 
            flex-col md:flex-row  items-center gap-4 md:justify-between grow">
                <ul class="flex flex-col md:flex-row md:items-center justify-center gap-4 text-xl font-semibold ">
                    <li><a href="#" class="hover:text-primary trasition duration-75">Home</a></li>
                    <li><a href="#" class="hover:text-primary trasition duration-75">Feature</a></li>
                    <li><a href="#" class="hover:text-primary trasition duration-75">About</a></li>
                </ul>


                <!-- Login Button -->
                <div class="flex text-center md:text-right">
                    <a href="{{ route('login') }}"
                        class="inline-block py-2 px-4 bg-blue-700 text-white rounded-lg text-lg hover:bg-blue-800 transition">
                        Login
                    </a>
                </div>

            </div>


        </nav>

    </header>

</body>

</html>