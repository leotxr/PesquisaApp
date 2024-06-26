<x-rating-layout>
    <div class="h-screen hero">
        <div class="text-center hero-content">
            <div class="max-w-full max-h-full">
                <form method="POST" action="{{route('GetDadosCliente')}}">
                    @csrf
                    <div class="grid max-w-full justify-items-center">
                        <x-icon name="horizontal-logo" class="w-64 h-24 text-primary" fill="#0a33a3"></x-icon>
                        <h1 class="text-4xl font-bold">Seja bem-vindo!</h1>
                        <p class="py-6 text-xl">Para iniciar insira abaixo o <span class="font-bold bg-lime-200 p-0.5">código de pesquisa de satisfação</span>
                            presente em
                            seu protocolo.</p>
                        <input autofocus minlength="6" maxlength="6" type="number"
                            placeholder="Insira o código de pesquisa" id="pacienteid" name="pacienteid"
                            class="w-full max-w-sm text-lg input input-bordered input-primary" />
                        <button type="submit"
                            class="mt-10 text-white border-none bg-primary hover:bg-blue-900 btn btn-wide">Buscar</button>
                    </div>
                </form>
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
