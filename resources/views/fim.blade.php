<x-rating-layout>
    <div class="pt-2">
        <a type="button" href="/"><x-secondary-button type="button">Nova
                pesquisa</x-secondary-button></a>
    </div>
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <div class="grid justify-items-center">
                {{-- <img src="{{ URL::asset('image/LOGO_ULTRIMAGEM_VERTICAL.png') }}" class="py-8" width="350px" height="350px"> --}}

                <div class="pt-2 text-center">
                    <h1 class="text-3xl font-bold">Nos avalie também no</h1>
                    <x-icon name="google-logo" class="w-36 mx-auto" fill="#0a33a3"></x-icon>
                </div>

                <x-icon name="qrcode-google" class="w-64 h-64 my-4" fill="#0a33a3"></x-icon>
                <x-icon name="five-stars" solid class="w-64 my-4" fill="#0a33a3"></x-icon>

                <div class="pt-2">
                    <h1 class="text-3xl font-bold">A Ultrimagem agradece sua avaliação!</h1>
                </div>
                <div class="pt-2">
                    <h1 class="text-xl font-bold">Iniciando nova pesquisa em <span id="mostrador"></span> segundos</h1>
                </div>

            </div>

        </div>
    </div>
</x-rating-layout>

<script>
    $(document).ready(function() {

        new Timer(0.5, mostrador, function() {
            window.location.href = "/";
        }).start();
        setTimeout(function() {

        }, 10000);



    });
    var mostrador = document.querySelector('#mostrador');

    function Timer(mins, target, cb) {
        this.counter = mins * 60;
        this.target = target;
        this.callback = cb;
    }
    Timer.prototype.pad = function(s) {
        return (s < 10) ? '0' + s : s;
    }
    Timer.prototype.start = function(s) {
        this.count();
    }
    Timer.prototype.stop = function(s) {
        this.count();
    }
    Timer.prototype.done = function(s) {
        if (this.callback) this.callback();
    }
    Timer.prototype.display = function(s) {
        this.target.innerHTML = this.pad(s);
    }
    Timer.prototype.count = function(s) {
        var self = this;
        self.display.call(self, self.counter);
        self.counter--;
        var clock = setInterval(function() {
            self.display(self.counter);
            self.counter--;
            if (self.counter < 0) {
                clearInterval(clock);
                self.done.call(self);
            }
        }, 1000);
    }
</script>
