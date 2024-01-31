<x-rating-layout>
    <div class="min-h-screen hero">
        <div class="text-center hero-content">
            <div class="grid max-w-full justify-items-center">
                {{--<img src="{{URL::asset('image/LOGO_ULTRIMAGEM_VERTICAL.png')}}" class="py-8" width="350px" height="350px"></img>--}}
                <x-icon name="vertical-logo" class="w-64 h-64" fill="#0a33a3"></x-icon>
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
