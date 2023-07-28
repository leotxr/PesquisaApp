@if($hideFatura != true )
<div class="h-screen hero" id="div-3">
    <div class="text-center hero-content">
        <div class="max-w-full">
            <div id="FATURA">
                
                @if($fatura->tec_name != NULL)
                <p class="max-w-xl text-2xl">Como você avalia o exame de <strong>{{$fatura->setor}}</strong> realizado pelo(a) técnico(a)</p>
                <div class="flex justify-center pt-2 text-center">
                    <img src="{{URL::asset('image/funcionarios').'/' . $fatura->tec_name . ('.png')}}"
                        class="justify-center scale-100 max-h-44 max-w-44"></img>  
                </div>
                <p for="mask" class="text-3xl font-bold">{{$fatura->tec_name}}</p>


                @else
                <p class="max-w-xl text-2xl">Como você avalia o exame de <strong>{{$fatura->setor}}</strong> realizado pelo(a) médico(a)</p>
                <div class="flex justify-center pt-2 text-center">
                    <img src="{{URL::asset('image/medicos').'/' . $fatura->livro_name . ('.png')}}"
                        class="justify-center scale-100 max-h-44 max-w-44"></img>
                </div>
                <p for="mask" class="text-3xl font-bold">{{$fatura->livro_name}}</p>
                @endif


                <div class="grid justify-center grid-cols-5 gap-5 py-2 text-xl font-bold rating" id="rating" required>
                    <div class="w-24 h-24 p-2 form-check form-check-inline">
                        <label class="radio-inline">
                            <input type="radio" wire:click="avaliaRadiologia" id="checkbox_{{$wire_function}}_1" wire:model="rate" name="nota" value="1"
                                class="radio" style="opacity: 0; position: absolute;" />
                            <img src="{{URL::asset('image/SMILE-01.png')}}" class="active:scale-125"></img>
                            Péssimo
                        </label>
                    </div>

                    <div class="w-24 h-24 p-2 form-check form-check-inline">
                        <label class="radio-inline">
                            <input type="radio" wire:click="avaliaRadiologia"  wire:model="rate" name="nota" value="2"
                            id="checkbox_{{$wire_function}}_2" class="radio" style="opacity: 0; position: absolute;" />
                            <img src="{{URL::asset('image/SMILE-02.png')}}" class="active:scale-125"></img>
                            Ruim
                        </label>
                    </div>

                    <div class="w-24 h-24 p-2 form-check form-check-inline">
                        <label class="radio-inline">
                            <input type="radio" wire:click="avaliaRadiologia" wire:model="rate" name="nota" value="3"
                            id="checkbox_{{$wire_function}}_3" class="radio" style="opacity: 0; position: absolute;" />
                            <img src="{{URL::asset('image/SMILE-03.png')}}" class="active:scale-125"></img>
                            Normal
                        </label>
                    </div>

                    <div class="w-24 h-24 p-2 form-check form-check-inline">
                        <label class="radio-inline">
                            <input type="radio" wire:click="avaliaRadiologia" wire:model="rate" name="nota" value="4"
                            id="checkbox_{{$wire_function}}_4" class="radio" style="opacity: 0; position: absolute;" />
                            <img src="{{URL::asset('image/SMILE-04.png')}}" class="active:scale-125"></img>
                            Bom
                        </label>
                    </div>

                    <div class="w-24 h-24 p-2 form-check form-check-inline">
                        <label class="radio-inline">
                            <input type="radio" wire:click="avaliaRadiologia" wire:model="rate" name="nota" value="5"
                            id="checkbox_{{$wire_function}}_5" class="radio" style="opacity: 0; position: absolute;" />
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