<x-guest-layout>
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-md grid justify-items-center">
                <img src="{{URL::asset('image/LOGO_ULTRIMAGEM.png')}}" width="200px" height="200px"></img>
                <span class="flex align-items-center">
                    <h1 class="text-5xl font-bold">Obrigado!   </h1>
                </span>

                <p class="py-6">A Ultrimagem agradece sua avaliação</p>

            </div>
        </div>
    </div>
</x-guest-layout>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            window.location.href = "/";
        }, 5000);
    });
</script>
