@if($hideFatura != true )
<div class="hero h-screen bg-base-200" id="div-3">
    <div class="hero-content text-center">
        <div class="max-w-full">
            <div id="FATURA">
                
                @if($fatura->tec_name != NULL)
                <p class="text-2xl max-w-xl">Como você avalia o exame de <strong>{{$fatura->setor}}</strong> realizado pelo(a) técnico(a)</p>
                <div class="flex justify-center pt-2 text-center">
                    <img src="{{URL::asset('image/funcionarios').'/' . $fatura->tec_name . ('.png')}}"
                        class="scale-100 max-h-44 max-w-44 justify-center"></img>  
                </div>
                <p for="mask" class="text-3xl font-bold">{{$fatura->tec_name}}</p>


                @else
                <p class="text-2xl max-w-xl">Como você avalia o exame de <strong>{{$fatura->setor}}</strong> realizado pelo(a) médico(a)</p>
                <div class="flex justify-center pt-2 text-center">
                    <img src="{{URL::asset('image/medicos').'/' . $fatura->livro_name . ('.png')}}"
                        class="scale-100 max-h-44 max-w-44 justify-center"></img>
                </div>
                <p for="mask" class="text-3xl font-bold">{{$fatura->livro_name}}</p>
                @endif


                <div class="rating flex justify-center gap-5 font-bold text-xl py-2" id="rating" required>
                    <div class="form-check form-check-inline h-24 w-24 p-2">
                        <label class="radio-inline">
                            <input type="radio" wire:click="avaliaRadiologia" wire:model="rate" name="nota" value="1"
                                class="radio" style="opacity: 0; position: absolute;" />
                            <img src="{{URL::asset('image/SMILE-01.png')}}" class="active:scale-125"></img>
                            Péssimo
                        </label>
                    </div>

                    <div class="form-check form-check-inline h-24 w-24 p-2">
                        <label class="radio-inline">
                            <input type="radio" wire:click="avaliaRadiologia" wire:model="rate" name="nota" value="2"
                                id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                            <img src="{{URL::asset('image/SMILE-02.png')}}" class="active:scale-125"></img>
                            Ruim
                        </label>
                    </div>

                    <div class="form-check form-check-inline h-24 w-24 p-2">
                        <label class="radio-inline">
                            <input type="radio" wire:click="avaliaRadiologia" wire:model="rate" name="nota" value="3"
                                id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                            <img src="{{URL::asset('image/SMILE-03.png')}}" class="active:scale-125"></img>
                            Normal
                        </label>
                    </div>

                    <div class="form-check form-check-inline h-24 w-24 p-2">
                        <label class="radio-inline">
                            <input type="radio" wire:click="avaliaRadiologia" wire:model="rate" name="nota" value="4"
                                id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                            <img src="{{URL::asset('image/SMILE-04.png')}}" class="active:scale-125"></img>
                            Bom
                        </label>
                    </div>

                    <div class="form-check form-check-inline h-24 w-24 p-2">
                        <label class="radio-inline">
                            <input type="radio" wire:click="avaliaRadiologia" wire:model="rate" name="nota" value="5"
                                id="checkbox" class="radio" style="opacity: 0; position: absolute;" />
                            <img src="{{URL::asset('image/SMILE-05.png')}}" class="active:scale-125"></img>
                            Ótimo
                        </label>
                    </div>

                </div>
                {{--
                <button type="submit" id="btn-ultri" href="" class="my-10 btn btn-primary btn-wide ">Avançar</button>
                --}}

            </div>
        </div>
    </div>
</div>
@else
<div>
</div>
@endif