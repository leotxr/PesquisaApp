<x-guest-layout>
    <form name="formAgenda" id="formAgenda" method="POST" action="{{route('sendDadosAgenda')}}">
        @csrf
        <div class="hero h-screen bg-base-200">
            <div class="hero-content text-center">
                <div class="max-w-full">
                    @foreach($agendas as $agenda)
                    <p class=" text-3xl">Como você avalia o agendamento do exame realizado pela </p>
                    <div class="flex justify-center pt-2 text-center">
                        <img src="{{URL::asset('image/funcionarios/').'/' . $agenda->ATENDENTE . ('.png')}}" class="scale-100 max-h-44 max-w-44 justify-center"></img>
                    </div>
                    <p for="mask" class="text-3xl font-bold">{{$agenda->ATENDENTE}}</p>
                    <input type="text" class=" py-10 text-3xl font-bold" name="data_req" value="{{$agenda->DATA}}" style="display: none"></input>
                    <input type="text" class=" py-10 text-3xl font-bold" name="paciente_id" value="{{$agenda->PACIENTEID}}" style="display: none"></input>
                    <input type="text" class="text-3xl font-bold" id="id" name="id" value="{{$requisicao}}" style="display: none;"></input>
                    <input type="text" style="display: none;" name="atendente_name" id="atendente_name" value="{{$agenda->ATENDENTE}}"></input>
                    <input class="text-3xl font-bold" id="grupo_id" name="grupo_id" value="{{$agenda->GRUPOID}}" style="display: none;"></input>

                    @endforeach
                    <div class="rating flex justify-center gap-5 font-bold text-xl py-5" id="rating" required>
                        <div class="form-check form-check-inline h-24 w-24">
                            <label class="radio-inline">
                                <input type="radio" name="rating1" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-01.png')}}" class="active:scale-125"></img>
                                Péssimo
                            </label>
                        </div>

                        <div class="form-check form-check-inline h-24 w-24">
                            <label class="radio-inline">
                                <input type="radio" name="rating1" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-02.png')}}" class="active:scale-125"></img>
                                Ruim
                            </label>
                        </div>

                        <div class="form-check form-check-inline h-24 w-24">
                            <label class="radio-inline">
                                <input type="radio" name="rating1" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-03.png')}}" class="active:scale-125"></img>
                                Normal
                            </label>
                        </div>

                        <div class="form-check form-check-inline h-24 w-24">
                            <label class="radio-inline">
                                <input type="radio" name="rating1" value="4" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-04.png')}}" class="active:scale-125"></img>
                                Bom
                            </label>
                        </div>

                        <div class="form-check form-check-inline h-24 w-24">
                            <label class="radio-inline">
                                <input type="radio" name="rating1" value="5" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-05.png')}}" class="active:scale-125"></img>
                                Ótimo
                            </label>
                        </div>

                    </div>
                    <button type="submit" id="btn-agenda" onclick="alterarDiv(this)" href="" class="my-16 btn btn-primary btn-wide ">Avançar</button>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            window.location.href = "/";
        }, 30000);
    });
</script>