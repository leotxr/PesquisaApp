<x-guest-layout>
    <form name="formAgenda" id="formAgenda" method="POST" action="{{route('sendDadosAgenda')}}">
        @csrf
        <div class="hero h-screen bg-base-200">
            <div class="hero-content text-center">
                <div class="max-w-lg">
                    @foreach($agendas as $agenda)
                    <p class=" text-3xl">Como você avalia o agendamento realizado pela </p>
                    <p class=" py-10 text-3xl font-bold">{{$agenda->ATENDENTE}}</p>
                    <input type="text" class=" py-10 text-3xl font-bold" name="data_req" value="{{$agenda->DATA}}" style="display: none"></input>
                    <input type="text" class=" py-10 text-3xl font-bold" name="paciente_id" value="{{$agenda->PACIENTEID}}" style="display: none"></input>
                    <input type="text" class="text-3xl font-bold" id="req_id" name="req_id" value="{{$requisicao}}" style="display: none;"></input>
                    <input type="text" style="display: none;" name="atendente_name" id="atendente_name" value="{{$agenda->ATENDENTE}}"></input>
                    @endforeach
                    <div class="rating flex justify-center gap-5" id="rating" required>
                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="rating1" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-01.png')}}" width="300px" height="300px"></img>
                                Péssimo
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="rating1" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-02.png')}}" width="300px" height="300px"></img>
                                Ruim
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="rating1" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-03.png')}}" width="300px" height="300px"></img>
                                Indiferente
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="rating1" value="4" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-04.png')}}" width="300px" height="300px"></img>
                                Bom
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="rating1" value="5" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-05.png')}}" width="300px" height="300px"></img>
                                Ótimo
                            </label>
                        </div>

                    </div>
                    <button type="submit" id="btn-agenda" onclick="alterarDiv(this)" href="" class="my-10 btn btn-primary btn-wide ">Avançar</button>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
