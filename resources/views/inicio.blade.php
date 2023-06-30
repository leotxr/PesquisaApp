<x-guest-layout>
    <div class="min-h-screen hero" style="background-image: url(/image/logofundo.png);">
        <div class="bg-white hero-overlay bg-opacity-95"></div>
        <div class="text-center hero-content text-neutral-content">
            <div class="max-w-xl">

                <div class="grid max-w-xl grid-cols-1 sm:grid-cols-1 justify-items-center">
                    <h1 class="py-5 text-5xl font-bold text-blue-700">Sua opinião é muito importante para nós!</h1>
                    <a href="{{ url('welcome') }}" type="button"
                        class="h-16 p-2 text-xl font-bold text-white bg-blue-800 border-2 border-none rounded-md hover:bg-blue-900 btn w-96">Iniciar
                        Pesquisa</a>

                </div>

            </div>
        </div>
    </div>

</x-guest-layout>