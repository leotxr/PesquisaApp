<x-guest-layout>
    <form name="formMed" id="formMed" method="POST" action="{{route('sendDadosMed')}}">
        <div class="formMed">
            @csrf
            @isset($recepus)
            @foreach($recepus as $us)
            <div class="hero h-screen bg-base-200" id="us">
                <div class="hero-content text-center">
                    <div class="max-w-full">

                        <p class="text-3xl">Como você avalia o atendimento realizado pela recepcionista da
                        <p class="text-3xl"> Ultra-sonografia </p>
                        </p>
                        <div class="flex justify-center pt-2 text-center">
                            <img src="{{URL::asset('image/funcionarios/').'/' . $us->USUARIO . ('.png')}}" class="scale-100 max-h-44 max-w-44 justify-center"></img>
                        </div>
                        <p for="mask" class="text-3xl font-bold">{{$us->USUARIO}}</p>
                        <input type="text" style="display: none;" name="us_name[]" value="{{$us->USUARIO}}"></input>
                        <div class="rating flex justify-center gap-5 font-bold text-xl py-5" id="rating" required>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="us_rate[]" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-01.png')}}" class="active:scale-125"></img>
                                    Péssimo
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="us_rate[]" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-02.png')}}" class="active:scale-125"></img>
                                    Ruim
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="us_rate[]" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-03.png')}}" class="active:scale-125"></img>
                                    Normal
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="us_rate[]" value="4" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-04.png')}}" class="active:scale-125"></img>
                                    Bom
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="us_rate[]" value="5" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-05.png')}}" class="active:scale-125"></img>
                                    Ótimo
                                </label>
                            </div>

                        </div>
                        <a class="proximo my-16 btn btn-primary btn-wide ">Próximo</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endisset

            @isset($enfermeiras)
            @foreach($enfermeiras as $enf)
            <div class="hero h-screen bg-base-200" id="enf">
                <div class="hero-content text-center">
                    <div class="max-w-full">

                        <p class="text-3xl">Como você avalia o atendimento realizado pela enfermeira </p>
                        <div class="flex justify-center pt-2 text-center">
                            <img src="{{URL::asset('image/funcionarios/').'/' . $enf->ENFERMEIRA . ('.png')}}" class="scale-100 max-h-44 max-w-44 justify-center"></img>
                        </div>
                        <p for="mask" class="text-3xl font-bold">{{$enf->ENFERMEIRA}}</p>
                        <input type="text" style="display: none;" name="enf_name[]" value="{{$enf->ENFERMEIRA}}"></input>

                        <div class="rating flex justify-center gap-5 font-bold text-xl py-5" id="rating" required>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="enf_rate[]" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-01.png')}}" class="active:scale-125"></img>
                                    Péssimo
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="enf_rate[]" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-02.png')}}" class="active:scale-125"></img>
                                    Ruim
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="enf_rate[]" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-03.png')}}" class="active:scale-125"></img>
                                    Normal
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="enf_rate[]" value="4" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-04.png')}}" class="active:scale-125"></img>
                                    Bom
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="enf_rate[]" value="5" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-05.png')}}" class="active:scale-125"></img>
                                    Ótimo
                                </label>
                            </div>

                        </div>
                        <a class="proximo my-16 btn btn-primary btn-wide ">Próximo</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endisset

            @isset($requisicoes)
            @foreach($requisicoes as $requisicao)
            <div class="hero h-screen bg-base-200" id="setor">
                <div class="hero-content text-center">
                    <div class="max-w-full">

                        <p class="text-3xl">Como você avalia o exame de {{$requisicao->SETOR}}</p>
                        @if(($requisicao->SETOR != "ULTRA-SON" && $requisicao->SETOR != "CARDIOLOGIA"))
                        <p class="text-3xl">realizado pelo(a) técnico(a)</p>
                        <div class="flex justify-center pt-2 text-center">
                            <img src="{{URL::asset('image/funcionarios/').'/' . $requisicao->TECNICO . ('.png')}}" class=" scale-100 max-h-44 max-w-44 justify-center"></img>
                        </div>
                        <p for="mask" class="text-3xl font-bold">{{$requisicao->TECNICO}}</p>
                        @else
                        <p class="text-3xl">realizado pelo(a) médico(a)</p>
                        <div class="flex justify-center pt-2 text-center">
                            <img src="{{URL::asset('image/medicos/').'/' . $requisicao->MEDICO . ('.png')}}" class="rounded-sm scale-100 max-h-44 max-w-44 justify-center"></img>
                        </div>
                        <p for="mask" class="text-3xl font-bold">{{$requisicao->MEDICO}}</p>
                        @endif


                        <input type="text" class="text-3xl font-bold" id="rating_id" name="rating_id[]" value="{{$rating_id}}" style="display: none;"></input>

                        <input type="text" class="text-3xl font-bold" id="data_fatura" name="data_fatura[]" value="{{$requisicao->DATA}}" style="display: none;"></input>
                        <input type="text" class="text-3xl font-bold" name="medico_name[]" value="{{$requisicao->MEDICO}}" style="display:none;"></input>
                        <input type="text" class="text-3xl font-bold" name="tecnico_name[]" value="{{$requisicao->TECNICO}}" style="display:none;"></input>
                        <input type="text" class="text-3xl font-bold" name="setor[]" value="{{$requisicao->SETOR}}" style="display:none;"></input>

                        <div class="rating flex justify-center gap-5 font-bold text-xl py-5" id="rating" required>
                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="med_rate[]" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-01.png')}}" class="active:scale-125"></img>
                                    Péssimo
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="med_rate[]" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-02.png')}}" class="active:scale-125"></img>
                                    Ruim
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="med_rate[]" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-03.png')}}" class="active:scale-125"></img>
                                    Normal
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="med_rate[]" value="4" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-04.png')}}" class="active:scale-125"></img>
                                    Bom
                                </label>
                            </div>

                            <div class="form-check form-check-inline h-24 w-24">
                                <label class="radio-inline">
                                    <input type="checkbox" name="med_rate[]" value="5" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                    <img src="{{URL::asset('image/SMILE-05.png')}}" class="active:scale-125"></img>
                                    Ótimo
                                </label>
                            </div>
                        </div>
                        <a class="proximo my-16 btn btn-primary btn-wide ">Próximo</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endisset

            <div class="hero min-h-screen bg-base-200">
                <div class="hero-content text-center">
                    <div class="max-w-xl">
                        <div class="grid justify-items-center">
                            <h1 class="text-3xl">Você recomendaria a <b>Ultrimagem</b> para um amigo ou familiar?</h1>
                            <div class="rating flex justify-center gap-5 py-10 font-bold text-xl" id="rating" required>

                                <div class="form-check form-check-inline h-24 w-24">
                                    <label class="radio-inline">
                                        <input type="radio" name="rec_rate" value="0" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                        <img src="{{URL::asset('image/SMILE-02.png')}}" class="active:scale-125"></img>
                                        Não
                                    </label>
                                </div>

                                <div class="form-check form-check-inline h-24 w-24">
                                    <label class="radio-inline">
                                        <input type="radio" name="rec_rate" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                        <img src="{{URL::asset('image/SMILE-05.png')}}" class="active:scale-125"></img>
                                        Sim
                                    </label>
                                </div>

                            </div>
                            <button type="submit" id="btn-med" href="" class="text-center btn btn-primary btn-wide my-10">Avançar</button>
                        </div>
                    </div>
                </div>
            </div>

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

    });
</script>