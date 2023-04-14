<x-guest-layout>
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-full grid justify-items-center">
                <img src="{{URL::asset('image/LOGO_ULTRIMAGEM.png')}}" class="py-16" width="350px" height="350px"></img>
                <span class="flex align-items-center pt-2">
                    <h1 class="text-3xl font-bold">A Ultrimagem agradece sua avaliação!   </h1>
                </span>


            </div>
        </div>
    </div>
</x-guest-layout>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            window.location.href = "welcome";
        }, 5000);
    });
</script>
