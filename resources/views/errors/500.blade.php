<x-guest-layout>
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold">Ocorreu um erro :(</h1>
                <p class="py-6">O que aconteceu?</p>
              


                <button class="btn btn-warning" >Tentar Novamente</button>
            </div>
        </div>
    </div>
</x-guest-layout>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            window.location.href = "/";
        }, 1);
    });
</script>