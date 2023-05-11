<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="winter">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>{{ config('app.name', 'Pesquisa de satisfação Ultrimagem') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <livewire:styles />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <livewire:scripts />
</head>

<body class="sm:overflow-hidden">

    <div class="font-sans antialiased text-gray-900 bg-base-200">
        
        @if($errors->any())
        @foreach($errors->all() as $error)
        <div class="absolute shadow-lg alert alert-warning">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{$error}}</span>
            </div>
        </div>
        @endforeach
        @endif
        
        <div>
            <livewire:templates.top>
            {{ $slot }}
            
            
            <div class="absolute top-0 grid w-full h-full loader-wrapper bg-base-200 place-items-center opacity-95" style="display:none">
                <div class="flex items-center ">
                <span class="loader"></span>
                
                    <h1 class="p-2 text-xl font-bold">Aguarde, estamos carregando suas informações...</h1>
                </div>
            </div>
            
        </div>

    </div>

</body>

</html>

<script>
    /*
    window.addEventListener("contextmenu", ev => {
        ev.preventDefault();
        return false;
    });
*/
    $("form").submit(function(){
        $(".loader-wrapper").show();
    });

    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
</script>
