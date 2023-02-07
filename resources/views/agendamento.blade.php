<x-guest-layout>
    <form name="formAgendamento" id="formAgendamento" method="POST" action="{{ route('sendDados') }}">
        <div class="formAgendamento">
            @csrf
            <!-- ATENDIMENTO -->
            @foreach ($requisicoes as $requisicao)
                <div class="hero h-screen bg-base-200" id="us">
                    <div class="hero-content text-center">
                        <div class="max-w-full">

                            <h1 class="text-3xl font-bold">Olá, {{ $requisicao->PACIENTE }}</h1>
                            <input class="text-3xl font-bold" id="data_req" name="data_req"
                                value="{{ $requisicao->DATA }}" style="display: none;"></input>

                            <input class="text-3xl font-bold" id="requisicao_id" name="requisicao_id"
                                value="{{ $requisicao->REQUISICAOID }}" style="display: none;"></input>

                            <input class="text-3xl font-bold" id="paciente_id" name="paciente_id"
                                value="{{ $requisicao->PACIENTEID }}" style="display: none;"></input>

                            <input class="text-3xl font-bold" id="paciente_name" name="paciente_name"
                                value="{{ $requisicao->PACIENTE }}" style="display: none;"></input>

                            <p class="py-1 text-3xl">para melhor atendê-lo(a), gostaríamos de saber se foi atendido(a):
                            </p>

                            <div class="rating flex justify-center gap-5 font-bold text-xl py-2" id="rating"
                                required>

                                <div class="form-check form-check-inline h-24 w-24 m-10">
                                    <label class="text-lg font-bold">
                                        <input type="radio" name="horario" value="3" id="checkbox"
                                            class="radio" style="opacity: 0; position: absolute;" />
                                        <img src="{{ URL::asset('image/SMILE-05.png') }}"
                                            class="active:scale-125"></img>
                                        Antes do horário
                                    </label>
                                </div>
                                <div class="form-check form-check-inline h-24 w-24 m-10">
                                    <label class="text-lg font-bold">
                                        <input type="radio" name="horario" value="2" id="checkbox"
                                            class="radio" style="opacity: 0; position: absolute;" />
                                        <img src="{{ URL::asset('image/SMILE-04.png') }}"
                                            class="active:scale-125"></img>
                                        No horário marcado
                                    </label>
                                </div>
                                <div class="form-check form-check-inline h-24 w-24 m-10">
                                    <label class="text-lg font-bold">
                                        <input type="radio" name="horario" value="1" class="radio"
                                            style="opacity: 0; position: absolute;" />
                                        <img src="{{ URL::asset('image/SMILE-01.png') }}"
                                            class="active:scale-125"></img>
                                        Depois do horário
                                    </label>
                                </div>
                            </div>
                            <a class="proximo my-16 btn btn-primary btn-wide ">Próximo</a>

                        </div>

                    </div>

                </div>
            @endforeach



            <!-- AGENDAMENTO -->
            @foreach ($agendas as $agenda)
                <div class="hero min-h-screen bg-base-200">
                    <div class="hero-content text-center">
                        <div class="max-w-xl">
                            <div class="grid justify-items-center">
                                <!-- cabecalho -->
                                <p class=" text-2xl">Como você avalia o agendamento do exame realizado pela </p>
                                <div class="flex justify-center pt-1 text-center">
                                    <img src="{{ URL::asset('image/funcionarios/') . '/' . $agenda->ATENDENTE . '.png' }}"
                                        class="scale-100 max-h-44 max-w-44 justify-center"></img>
                                </div>
                                <p for="mask" class="text-2xl font-bold">{{ $agenda->ATENDENTE }}</p>

                                <!-- valores -->
                                <input type="text" style="display: none;" name="atendente_name" id="atendente_name"
                                    value="{{ $agenda->ATENDENTE }}"></input>
                                <input class="text-2xl font-bold" id="grupo_id" name="grupo_id"
                                    value="{{ $agenda->GRUPOID }}" style="display: none;"></input>

                                <!-- rating -->
                                <div class="rating flex justify-center gap-4 sm:gap-4 font-bold text-lg py-2"
                                    id="rating" required>

                                    <div class="form-check form-check-inline h-24 w-24 p-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="rating1" value="1" class="radio"
                                                style="opacity: 0; position: absolute;"/>
                                            <img src="{{ URL::asset('image/SMILE-01.png') }}"
                                                class="active:scale-125"></img>
                                            Péssimo
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline h-24 w-24 p-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="rating1" value="2" id="checkbox"
                                                class="radio" style="opacity: 0; position: absolute;" />
                                            <img src="{{ URL::asset('image/SMILE-02.png') }}"
                                                class="active:scale-125"></img>
                                            Ruim
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline h-24 w-24 p-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="rating1" value="3" id="checkbox"
                                                class="radio" style="opacity: 0; position: absolute;" />
                                            <img src="{{ URL::asset('image/SMILE-03.png') }}"
                                                class="active:scale-125"></img>
                                            Normal
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline h-24 w-24 p-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="rating1" value="4" id="checkbox"
                                                class="radio" style="opacity: 0; position: absolute;" />
                                            <img src="{{ URL::asset('image/SMILE-04.png') }}"
                                                class="active:scale-125"></img>
                                            Bom
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline h-24 w-24 p-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="rating1" value="5" id="checkbox"
                                                class="radio" style="opacity: 0; position: absolute;" />
                                            <img src="{{ URL::asset('image/SMILE-05.png') }}"
                                                class="active:scale-125"></img>
                                            Ótimo
                                        </label>
                                    </div>

                                </div>
                                <a class="proximo my-16 btn btn-primary btn-wide ">Próximo</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <!-- RECEPCAO -->
            @foreach ($requisicoes as $recep)
                <div class="hero h-screen bg-base-200" id="us">
                    <div class="hero-content text-center">
                        <div class="max-w-full">

                            <p class="text-3xl">Como você avalia o atendimento realizado pela recepcionista </p>
                            <div class="flex justify-center pt-2 text-center">
                                <img src="{{ URL::asset('image/funcionarios') . '/' . $requisicao->RECEPCIONISTA . '.png' }}"
                                    class="scale-100 max-h-44 max-w-44 justify-center"></img>

                            </div>

                            <p for="mask" class="text-3xl font-bold">{{ $requisicao->RECEPCIONISTA }}</p>
                            <input type="text" style="display: none;" name="recepcionista_name"
                                value="{{ $requisicao->RECEPCIONISTA }}"></input>


                            <div class="rating flex justify-center gap-5 font-bold text-xl py-2" id="rating"
                                required>
                                <div class="form-check form-check-inline h-24 w-24 p-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="rating2" value="1" class="radio"
                                            style="opacity: 0; position: absolute;" />
                                        <img src="{{ URL::asset('image/SMILE-01.png') }}"
                                            class="active:scale-125"></img>
                                        Péssimo
                                    </label>
                                </div>

                                <div class="form-check form-check-inline h-24 w-24 p-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="rating2" value="2" id="checkbox"
                                            class="radio" style="opacity: 0; position: absolute;" />
                                        <img src="{{ URL::asset('image/SMILE-02.png') }}"
                                            class="active:scale-125"></img>
                                        Ruim
                                    </label>
                                </div>

                                <div class="form-check form-check-inline h-24 w-24 p-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="rating2" value="3" id="checkbox"
                                            class="radio" style="opacity: 0; position: absolute;" />
                                        <img src="{{ URL::asset('image/SMILE-03.png') }}"
                                            class="active:scale-125"></img>
                                        Normal
                                    </label>
                                </div>

                                <div class="form-check form-check-inline h-24 w-24 p-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="rating2" value="4" id="checkbox"
                                            class="radio" style="opacity: 0; position: absolute;" />
                                        <img src="{{ URL::asset('image/SMILE-04.png') }}"
                                            class="active:scale-125"></img>
                                        Bom
                                    </label>
                                </div>

                                <div class="form-check form-check-inline h-24 w-24 p-2">
                                    <label class="radio-inline">
                                        <input type="radio" name="rating2" value="5" id="checkbox"
                                            class="radio" style="opacity: 0; position: absolute;" />
                                        <img src="{{ URL::asset('image/SMILE-05.png') }}"
                                            class="active:scale-125"></img>
                                        Ótimo
                                    </label>
                                </div>

                            </div>
                            <button type="submit" id="btn-recepcao"
                                class="enviar btn my-16 btn-primary btn-wide ">Avançar</button>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

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


        $("input").on("click", function() {
            $('html, body').animate({
                scrollTop: $(window).scrollTop() + 650
            }, 0);
        });

*/

        setTimeout(function() {
            window.location.href = "/";
        }, 120000);

        var telas = $(".formMed > .hero").length;
        $(".proximo").on("click", function() {

            $(this).closest(".hero").hide();

            var indice = $(".formMed a.proximo").index(this);

            indice += indice == telas - 1 ? -telas + 1 : 1;

            $(".formMed > .hero").eq(indice).show();
        });

        $('.enviar').click(function()
        {
            $('.enviar').addClass("loading");
        });
     
        

    });
</script>
