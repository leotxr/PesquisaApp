<div>
    @if (!$hideForm)
        <div wire:loading.remove class="h-screen hero" id="div-3">
            <div class="text-center hero-content">
                <div class="max-w-full">
                    <div class="grid grid-rows-3 sm:grid-rows-6 text-center justify-items-center">
                        <div class="row-span-1 sm:row-span-1">
                            <p class="max-w-xl text-2xl">{{$text}}</p>
                        </div>
                        <div class="row-span-1 sm:row-span-2">
                            <div class="flex justify-center pt-2 text-center">
                                @if ($label != 'Ultrimagem')
                                    <img src="{{ URL::asset($photo) }}"
                                         class="justify-center scale-100 max-h-44 max-w-44 ring-blue-400" />
                                @endif
                            </div>
                            <p class="text-3xl font-bold">{{ strtoupper($label) }}</p>
                        </div>
                        <div class="row-span-1 sm:row-span-2">
                            <div
                                class="grid justify-items-center grid-cols-6 sm:grid-cols-9 gap-4 py-2 text-xl font-bold space-x-4"
                                id="rating" required>
                                <div class="col-span-2 sm:col-span-3 text-center justify-items-center">
                                    <div class="active:scale-90">
                                        <label class="radio-inline">
                                            <input type="radio" wire:click="{{ $wire_function }}" wire:model.live="rate"
                                                   name="nota"
                                                   value="1" class="radio" style="opacity: 0; position: absolute;"/>
                                            <x-icon name="new-emoji-angry" class="w-24 h-24 shadow-lg rounded-full"
                                                    solid></x-icon>
                                            Péssimo
                                        </label>
                                    </div>
                                    <div class="w-full bg-red-600"></div>
                                </div>
                                <div class="col-span-2 sm:col-span-3 text-center justify-items-center">
                                    <div class="active:scale-90">
                                        <label class="radio-inline">
                                            <input type="radio" wire:click="{{ $wire_function }}" wire:model.live="rate"
                                                   name="nota"
                                                   value="3" id="checkbox_{{$wire_function}}_3" class="radio"
                                                   style="opacity: 0; position: absolute;"/>
                                            <x-icon name="new-emoji-neutral"
                                                    class="w-24 h-24 active:scale-90 shadow-lg rounded-full"
                                                    solid></x-icon>
                                            Regular
                                        </label>
                                    </div>
                                    <div class="w-full bg-yellow-400"></div>
                                </div>

                                <div class="col-span-2 sm:col-span-3 text-center justify-items-center">
                                    <div class="active:scale-90">
                                        <label class="radio-inline">
                                            <input type="radio" wire:click="{{ $wire_function }}" wire:model.live="rate"
                                                   name="nota" value="5" id="checkbox_{{$wire_function}}_5"
                                                   class="radio"
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
    @elseif($showTextArea == true)
        <div>
            @livewire('forms.form-comentario', ['rating' => $rating]);
        </div>
    @else
        <div>
        </div>
    @endif
</div>
