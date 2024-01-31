<div>
    @if(!$hideFatura)
        <div class="h-screen hero" id="div-3">
            <div class="text-center hero-content">
                <div class="max-w-full">
                    <div class="grid grid-rows-3 sm:grid-rows-6 gap-2 text-center justify-items-center">

                        @if($fatura->tec_name != NULL)
                            @php
                                $tec = $fatura->employees()->where('role', 'tec')->first();
                            @endphp
                            <div class="row-span-1 sm:row-span-1">
                                <p class="max-w-xl text-2xl">Como você avalia o exame de
                                    <strong>{{$fatura->setor}}</strong>
                                    realizado pelo(a) técnico(a)</p>
                            </div>
                            <div class="row-span-1 sm:row-span-2">
                                <div class="flex justify-center pt-2 text-center">
                                    <img src="{{URL::asset($tec->photo) ?? URL::asset('image/funcionarios').'/' . $fatura->tec_name . ('.png')}}"
                                         class="justify-center scale-100 max-h-44 max-w-44"></img>
                                </div>
                                <p for="mask" class="text-3xl font-bold">
                                    {{strtoupper($tec->description_name)}}</p>
                            </div>
                        @else
                            <div class="row-span-1 sm:row-span-1">
                                <p class="max-w-xl text-2xl">Como você avalia o exame de
                                    <strong>{{$fatura->setor}}</strong>
                                    realizado pelo(a) médico(a)</p>
                            </div>
                            <div class="row-span-1 sm:row-span-2">
                                <div class="flex justify-center pt-2 text-center">
                                    <img src="{{URL::asset('image/medicos').'/' . $fatura->livro_name . ('.png')}}"
                                         class="justify-center scale-100 max-h-44 max-w-44"></img>
                                </div>
                                <p for="mask" class="text-3xl font-bold">{{$fatura->livro_name}}</p>
                            </div>
                        @endif

                        <div class="row-span-1 sm:row-span-2">
                            <div
                                class="grid justify-items-center grid-cols-6 sm:grid-cols-9 gap-4 py-2 text-xl font-bold space-x-4"
                                id="rating" required>
                                <div class="col-span-2 sm:col-span-3 text-center justify-items-center">
                                    <div class="active:scale-90">
                                        <label class="radio-inline">
                                            <input type="radio" wire:click="avaliaRadiologia"
                                                   id="checkbox_{{$wire_function}}_1"
                                                   wire:model.live="rate" name="nota" value="1"
                                                   class="radio" style="opacity: 0; position: absolute;"/>
                                            <x-icon name="new-emoji-angry"
                                                    class="w-24 h-24 active:scale-90 shadow-lg rounded-full"
                                                    solid></x-icon>
                                            Péssimo
                                        </label>
                                    </div>
                                </div>

                                <div class="col-span-2 sm:col-span-3 text-center justify-items-center">
                                    <div class="active:scale-90">
                                        <label class="radio-inline">
                                            <input type="radio" wire:click="avaliaRadiologia" wire:model.live="rate"
                                                   name="nota"
                                                   value="3"
                                                   id="checkbox_{{$wire_function}}_3" class="radio"
                                                   style="opacity: 0; position: absolute;"/>
                                            <x-icon name="new-emoji-neutral"
                                                    class="w-24 h-24 active:scale-90 shadow-lg rounded-full"
                                                    solid></x-icon>
                                            Regular
                                        </label>
                                    </div>
                                </div>

                                <div class="col-span-2 sm:col-span-3 text-center justify-items-center">
                                    <div class="active:scale-90">
                                        <label class="radio-inline">
                                            <input type="radio" wire:click="avaliaRadiologia" wire:model.live="rate"
                                                   name="nota"
                                                   value="5"
                                                   id="checkbox_{{$wire_function}}_5" class="radio"
                                                   style="opacity: 0; position: absolute;"/>
                                            <x-icon name="new-emoji-happy"
                                                    class="w-24 h-24 active:scale-90 shadow-lg rounded-full"
                                                    solid></x-icon>
                                            Ótimo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div>
        </div>
    @endif
</div>
