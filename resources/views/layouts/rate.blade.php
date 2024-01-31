<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="ultrimagem">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>{{ config('app.name', 'Pesquisa de satisfação Ultrimagem') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <livewire:styles/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <livewire:scripts/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body class="overflow-hidden sm:overflow-hidden" >

<div class="font-sans antialiased text-gray-900 bg-gradient-to-r from-rose-100 to-teal-100">
    <main>

        <livewire:templates.top/>

        {{ $slot }}
        <div class="absolute top-0 grid w-full h-full loader-wrapper bg-base-200 place-items-center opacity-95 "
             style="display:none">
            <div class="flex items-center ">
                <span class="loader"></span>

                <h1 class="p-2 text-xl font-bold">Aguarde, estamos carregando suas informações...</h1>
            </div>
        </div>
    </main>

</div>

</body>

</html>
<script>

    window.addEventListener("contextmenu", ev => {
        ev.preventDefault();
        return false;
    });

    $("form").submit(function () {
        $(".loader-wrapper").show();
    });

    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 5000);

    @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}"
    switch (type) {
        case 'info':

            toastr.options.timeOut = 10000;
            toastr.info("{{ Session::get('message') }}");
            break;
        case 'success':

            toastr.options.timeOut = 10000;
            toastr.success("{{ Session::get('message') }}");

            break;
        case 'warning':

            toastr.options.timeOut = 10000;
            toastr.warning("{{ Session::get('message') }}");

            break;
        case 'error':

            toastr.options.timeOut = 10000;
            toastr.error("{{ Session::get('message') }}");

            break;
    }
    @endif

</script>
