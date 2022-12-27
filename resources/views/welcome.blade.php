<x-guest-layout>

    <div class="hero h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-full">
                <form name="formSearch" id="formSearch" method="POST" action="{{route('get-dados')}}">
                    @csrf
                    <div class="max-w-xl grid justify-items-center">
                        <img src="{{URL::asset('image/LOGO_ULTRIMAGEM.png')}}" class="py-10" width="200px" height="200px"></img>
                        <h1 class="text-5xl font-bold">Seja bem-vindo!</h1>
                        <p class="py-6 text-lg">Para iniciar insira abaixo o <b>código de pesquisa de satisfação</b> presente em seu protocolo.</p>
                        <input autofocus type="number" required placeholder="Insira o código de pesquisa" id="id" name="id" class="input input-bordered input-primary w-full max-w-xs" />
                        <button class="btn m-10 btn-primary btn-wide">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-guest-layout>
