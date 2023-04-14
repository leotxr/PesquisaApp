<x-guest-layout>
    <div class="hero h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-full max-h-full">
                <form method="POST" action="{{route('GetDadosCliente')}}">
                    @csrf
                    <div class="max-w-full grid justify-items-center">
                        <img src="{{URL::asset('image/LOGO_ULTRIMAGEM.png')}}" class="py-5" width="200px"
                            height="200px"></img>
                        <h1 class="text-5xl font-bold">Seja bem-vindo!</h1>
                        <p class="py-6 text-xl">Para iniciar insira abaixo o <b>código de pesquisa de satisfação</b>
                            presente em
                            seu protocolo.</p>
                        <input autofocus minlength="6" maxlength="6" type="number"
                            placeholder="Insira o código de pesquisa" id="pacienteid" name="pacienteid"
                            class="input input-bordered input-primary w-full max-w-sm text-lg" />
                        <button type="submit" class="btn mt-10 btn-primary btn-wide">Buscar</button>
                    </div>

            </div>
        </div>
    </div>
</x-guest-layout>
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