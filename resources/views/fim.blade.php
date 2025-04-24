<x-rating-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <div class="grid justify-items-center">
                {{--<img src="{{ URL::asset('image/LOGO_ULTRIMAGEM_VERTICAL.png') }}" class="py-8" width="350px" height="350px">--}}

                <div class="pt-2 text-center">
                    <h1 class="text-3xl font-bold">Nos avalie também no</h1> 
                    <x-icon name="google-logo" class="w-36 mx-auto" fill="#0a33a3"></x-icon>
                </div>
                
                <x-icon name="qrcode-google" class="w-64 h-64 my-4" fill="#0a33a3"></x-icon>
                <x-icon name="five-stars" solid class="w-64 my-4" fill="#0a33a3"></x-icon>

                <div class="pt-2">
                    <h1 class="text-3xl font-bold">A Ultrimagem agradece sua avaliação!</h1>
                </div>
            </div>
        </div>
    </div>
</x-rating-layout>

<script>
    $(document).ready(function() {
        
        setTimeout(function() {
            window.location.href = "/";
        }, 10000);
        
    });
</script>
