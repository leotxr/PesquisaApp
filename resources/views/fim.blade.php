<x-rating-layout>
    <div class="min-h-screen hero">
        <div class="text-center hero-content">
            <div class="grid max-w-full justify-items-center">
                <img src="{{URL::asset('image/LOGO_ULTRIMAGEM.png')}}" class="py-8" width="350px" height="350px"></img>
                <span class="flex pt-2 align-items-center">
                    <h1 class="text-3xl font-bold">A Ultrimagem agradece sua avaliação!   </h1>
                </span>


            </div>
        </div>
    </div>
</x-rating-layout>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            window.location.href = "/";
        }, 3000);
    });
</script>
