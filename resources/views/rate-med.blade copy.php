<x-guest-layout>
    <form name="formMed" id="formMed" method="POST" action="{{route('sendDadosMed')}}">
        @csrf
        @isset($recepus)
        @foreach($recepus as $us)
        <div class="hero h-screen bg-base-200" id="div-3">
            <div class="hero-content text-center">
                <div class="max-w-lg">

                    <p class="text-3xl">Como você avalia o atendimento realizado pela recepcionista </p>
                    <p class=" py-10 text-3xl font-bold">{{$us->USUARIO}}</p>
                    <input type="text" style="display: none;" name="us_name[]" value="{{$us->USUARIO}}"></input>
                    <div class="rating flex justify-center gap-5 py-10" id="rating" required>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="us_rate[]" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-01.png')}}" width="300px" height="300px"></img>
                                Péssimo
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="us_rate[]" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-02.png')}}" width="300px" height="300px"></img>
                                Ruim
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="us_rate[]" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-03.png')}}" width="300px" height="300px"></img>
                                Indiferente
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="us_rate[]" value="4" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-04.png')}}" width="300px" height="300px"></img>
                                Bom
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="us_rate[]" value="5" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-05.png')}}" width="300px" height="300px"></img>
                                Ótimo
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endisset

        @isset($enfermeiras)
        @foreach($enfermeiras as $enf)
        <div class="hero h-screen bg-base-200" id="div-3[]">
            <div class="hero-content text-center">
                <div class="max-w-lg">

                    <p class="text-3xl">Como você avalia o atendimento realizado pela enfermeira </p>
                    <p class=" py-10 text-3xl font-bold">{{$enf->ENFERMEIRA}}</p>
                    <input type="text" style="display: none;" name="enf_name[]" value="{{$enf->ENFERMEIRA}}"></input>

                    <div class="rating flex justify-center gap-5 py-10" id="rating" required>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="enf_rate[]" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-01.png')}}" width="300px" height="300px"></img>
                                Péssimo
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="enf_rate[]" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-02.png')}}" width="300px" height="300px"></img>
                                Ruim
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="enf_rate[]" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-03.png')}}" width="300px" height="300px"></img>
                                Indiferente
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="enf_rate[]" value="4" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-04.png')}}" width="300px" height="300px"></img>
                                Bom
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="enf_rate[]" value="5" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-05.png')}}" width="300px" height="300px"></img>
                                Ótimo
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endisset

        @isset($requisicoes)
        @foreach($requisicoes as $requisicao)
        <div class="hero h-screen bg-base-200" id="div-4[]">
            <div class="hero-content text-center">
                <div class="max-w-lg">

                    <p class="text-3xl">Como você avalia o exame de {{$requisicao->SETOR}}</p>
                    @if(($requisicao->SETOR != "ULTRA-SON" && $requisicao->SETOR != "CARDIOLOGIA"))
                    <p class="text-3xl">realizado pelo(a) técnico(a)</p>
                    <p class=" py-10 text-3xl font-bold">{{$requisicao->TECNICO}}</p>
                    @else
                    <p class="text-3xl">realizado pelo(a) médico(a)</p>
                    <p class=" py-10 text-3xl font-bold">{{$requisicao->MEDICO}}</p>
                    @endif


                    <input type="text" class="text-3xl font-bold" id="req_id" name="req_id[]" value="{{$req_id}}" style="display: none;"></input>
                    <input type="text" class="text-3xl font-bold" id="data_fatura" name="data_fatura[]" value="{{$requisicao->DATA}}" style="display: none;"></input>
                    <input type="text" class=" py-10 text-3xl font-bold" name="medico_name[]" value="{{$requisicao->MEDICO}}" style="display:none;"></input>
                    <input type="text" class=" py-10 text-3xl font-bold" name="tecnico_name[]" value="{{$requisicao->TECNICO}}" style="display:none;"></input>
                    <input type="text" class=" py-10 text-3xl font-bold" name="setor[]" value="{{$requisicao->SETOR}}" style="display:none;"></input>

                    <div class="rating flex justify-center gap-5 py-10" id="rating" required>
                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="med_rate[]" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-01.png')}}" width="300px" height="300px"></img>
                                Péssimo
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="med_rate[]" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-02.png')}}" width="300px" height="300px"></img>
                                Ruim
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="med_rate[]" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-03.png')}}" width="300px" height="300px"></img>
                                Indiferente
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="med_rate[]" value="4" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-04.png')}}" width="300px" height="300px"></img>
                                Bom
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="med_rate[]" value="5" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-05.png')}}" width="300px" height="300px"></img>
                                Ótimo
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endisset
        <div class="rating flex justify-center bg-base-200">
            <button type="submit" id="btn-med" href="#div-5" class="text-center btn btn-primary btn-wide mb-40">Avançar</button>
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
        */

        $("input").on("click", function() {
            $('html, body').animate({
                scrollTop: $(window).scrollTop() + 600
            }, 1366);
        });


    });
</script>
