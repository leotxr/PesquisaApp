<x-guest-layout>
    <form name="formUltri" id="formUltri" method="POST" action="{{route('sendDadosUltri')}}">
        @csrf
        <div class="hero h-screen bg-base-200">
            <div class="hero-content text-center justify-center">
                <div class="max-w-lg">
                    @foreach($rating_id as $req)
                    <input type="text" class="text-3xl font-bold" id="id" name="id" value="{{$req}}" style="display: none;"></input>
                    @endforeach
                    <p class=" text-3xl">Como você avalia a <b>Ultrimagem?</b></p>
                    <div class="rating flex justify-center gap-5 font-bold" id="rating" required>
                        <div class="form-check form-check-inline">
                            <label class="radio-inline font-bold">
                                <input type="checkbox" name="rate_clinica" value="1" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-01.png')}}" width="300px" height="300px"></img>
                                Péssimo
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="rate_clinica" value="2" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-02.png')}}" width="300px" height="300px"></img>
                                Ruim
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="rate_clinica" value="3" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-03.png')}}" width="300px" height="300px"></img>
                                Indiferente
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="rate_clinica" value="4" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-04.png')}}" width="300px" height="300px"></img>
                                Bom
                            </label>
                        </div>

                        <div class="form-check form-check-inline">
                            <label class="radio-inline">
                                <input type="checkbox" name="rate_clinica" value="5" id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                                <img src="{{URL::asset('image/SMILE-05.png')}}" width="300px" height="300px"></img>
                                Ótimo
                            </label>
                        </div>
                    </div>
                    <button type="submit" id="btn-ultri" href="" class="my-10 btn btn-primary btn-wide ">Avançar</button>
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