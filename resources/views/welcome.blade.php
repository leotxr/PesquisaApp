<x-rating-layout>
    <div class="h-screen hero bg-base-200">
        <div class="text-center hero-content">
            <div class="max-w-full max-h-full">
                <form method="POST" action="{{route('GetDadosCliente')}}">
                    @csrf
                    <div class="grid max-w-full justify-items-center">
                        <img src="{{URL::asset('image/LOGO_ULTRIMAGEM.png')}}" class="py-5" width="200px"
                            height="200px"></img>
                        <h1 class="text-5xl font-bold">Seja bem-vindo!</h1>
                        <p class="py-6 text-xl">Para iniciar insira abaixo o <b>código de pesquisa de satisfação</b>
                            presente em
                            seu protocolo.</p>
                        <input autofocus minlength="6" maxlength="6" type="number"
                            placeholder="Insira o código de pesquisa" id="pacienteid" name="pacienteid"
                            class="w-full max-w-sm text-lg input input-bordered input-primary" />
                        <button type="submit" class="mt-10 text-white bg-blue-800 border-none hover:bg-blue-900 btn btn-wide">Buscar</button>
                    </div>

            </div>
        </div>
    </div>
</x-rating-layout>
<script>
    
    /*
    $(document).ready(function() {
        setTimeout(function() {
            window.location.href = "/";
        }, 120000);
        $('.btn').click(function()
        {
            $('.btn').addClass("loading");
        });
    });
    */
</script>