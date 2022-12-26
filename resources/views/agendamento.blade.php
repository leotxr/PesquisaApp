<x-guest-layout>
    <form name="formAgendamento" id="formAgendamento" method="POST" action="{{route('sendDados')}}">
        @csrf
        <div class="hero h-screen bg-base-200">
            <div class="hero-content text-center">
                <div class="max-w-md ">
                    @foreach($requisicoes as $requisicao)
                    <h1 class="text-3xl font-bold">Olá, {{$requisicao->PACIENTE}}</h1>
                    <input class="text-3xl font-bold" id="data_req" name="data_req" value="{{$requisicao->DATA}}" style="display: none;"></input>
                    <input class="text-3xl font-bold" id="id" name="id" value="{{$requisicao->REQUISICAOID}}" style="display: none;"></input>
                    <input class="text-3xl font-bold" id="paciente_id" name="paciente_id" value="{{$requisicao->PACIENTEID}}" style="display: none;"></input>
                    <input class="text-3xl font-bold" id="paciente_name" name="paciente_name" value="{{$requisicao->PACIENTE}}" style="display: none;"></input>
                    <p class="py-4 text-3xl">para melhor atendê-lo(a), gostaríamos de saber se foi atendido(a):</p>

                    <div class="rating gap-14 grid-cols-4 justify-between" id="rating" required>

                        <div class="flex form-check form-check-inline ">
                            <label class="text font-bold">
                                <input type="radio" name="horario" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-05.png')}}" width="100px" height="100px"></img>
                                Antes do horário
                            </label>
                        </div>

                        <div class="flex form-check form-check-inline">
                            <label class="text font-bold">
                                <input type="radio" name="horario" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-04.png')}}" width="100px" height="100px"></img>
                                No horário marcado
                            </label>
                        </div>

                        <div class="flex form-check form-check-inline ">
                            <label class="text font-bold">
                                <input type="radio" name="horario" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-01.png')}}" width="100px" height="100px"></img>
                                Depois do horário
                            </label>
                        </div>





                    </div>
                    <button type="submit" id="btn-show-agenda" href="" onclick="alterarDiv(this)" class="my-10 btn btn-primary btn-wide ">Avançar</button>
                </div>
                @endforeach
            </div>
        </div>

    </form>
</x-guest-layout>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            window.location.href = "/";
        }, 60000);
    });
</script>
