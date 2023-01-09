<x-guest-layout>
    <form name="formRecepcao" id="formRecepcao" method="POST" action="{{route('sendDadosRecepcao')}}">
        @csrf
        @foreach($requisicoes as $requisicao)
        <div class="hero h-screen bg-base-200" id="div-3">
            <div class="hero-content text-center">
                <div class="max-w-full">

                    <p class="text-3xl">Como você avalia o atendimento realizado pela recepcionista </p>
                    <div class="flex justify-center pt-2 text-center">
                        <img src="{{URL::asset('image/funcionarios').'/' . $requisicao->RECEPCIONISTA . ('.png')}}" class="scale-100 max-h-44 max-w-44 justify-center"></img>
                        
                    </div>
                    <p for="mask" class="text-3xl font-bold">{{$requisicao->RECEPCIONISTA}}</p>
                    <input type="text" style="display: none;" name="recepcionista_name" value="{{$requisicao->RECEPCIONISTA}}"></input>
                    <input type="text" class="text-3xl font-bold" id="id" name="id" value="{{$id}}" style="display: none;"></input>

                    <div class="rating flex justify-center gap-5 font-bold text-xl pb-5" id="rating" required>
                        <div class="form-check form-check-inline h-24 w-24">
                            <label class="radio-inline">
                                <input type="radio" name="rating2" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-01.png')}}" class="active:scale-125"></img>
                                Péssimo
                            </label>
                        </div>

                        <div class="form-check form-check-inline h-24 w-24">
                            <label class="radio-inline">
                                <input type="radio" name="rating2" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-02.png')}}" class="active:scale-125"></img>
                                Ruim
                            </label>
                        </div>

                        <div class="form-check form-check-inline h-24 w-24">
                            <label class="radio-inline">
                                <input type="radio" name="rating2" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-03.png')}}" class="active:scale-125"></img>
                                Normal
                            </label>
                        </div>

                        <div class="form-check form-check-inline h-24 w-24">
                            <label class="radio-inline">
                                <input type="radio" name="rating2" value="4" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-04.png')}}" class="active:scale-125"></img>
                                Bom
                            </label>
                        </div>

                        <div class="form-check form-check-inline h-24 w-24">
                            <label class="radio-inline">
                                <input type="radio" name="rating2" value="5" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-05.png')}}" class="active:scale-125"></img>
                                Ótimo
                            </label>
                        </div>

                    </div>
                    <button type="submit" id="btn-recepcao" onclick="alterarDiv(this)" href="#div-4" class="my-16 btn btn-primary btn-wide ">Avançar</button>
                </div>
            </div>
        </div>
        @endforeach
    </form>
</x-guest-layout>
<script>
    $(document).ready(function() {

        /*
        $('.form-check').click(function() {
            $('html, body').animate({
                // aqui pega a posição atual e diminui
                scrollTop: $(window).scrollTop() + 600
            }, 1280);
            return false;

        });
        */


    });
</script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            window.location.href = "/";
        }, 30000);
    });
</script>