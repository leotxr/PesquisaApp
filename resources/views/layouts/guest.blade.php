<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="winter">

<head>
    <script>
        unloadScrollBars();
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>{{ config('app.name', 'Pesquisa de satisfação Ultrimagem') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="">

    <div class="font-sans text-gray-900 antialiased bg-base-200">
        @if($errors->any())
        @foreach($errors->all() as $error)
        <div class="alert alert-warning shadow-lg absolute">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{$error}}</span>
            </div>
        </div>
        @endforeach
        @endif
        <div>
            {{ $slot }}
            <div class="loader-wrapper bg-base-200 absolute w-full h-full grid place-items-center top-0 opacity-90">
                <span class="loader"></span>
            </div>
        </div>

    </div>

</body>

</html>

<script>
    window.addEventListener("contextmenu", ev => {
        ev.preventDefault();
        return false;
    });

    $(window).on("load",function(){
        $(".loader-wrapper").fadeOut("slow");
    });
</script>
