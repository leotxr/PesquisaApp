<div>
    <form wire:submit="update">
        <x-modal.dialog wire:model="modalEdit">
            <x-slot:title>
                Editar Funcionário
            </x-slot:title>
            <x-slot:content>
                <div class="grid grid-cols-3 sm:grid-cols-6 gap-4 p-6">
                    <div class="flex col-span-3 sm:col-span-2">
                        <div>
                            @if($photo)
                                <img class="w-24 h-24 rounded-full" src="{{URL::asset($photo->temporaryUrl())}}"
                                     alt="nova foto"/>
                            @else
                                @isset($employee->photo)
                                    <img class="w-24 h-24 rounded-full" src="{{URL::asset($employee->photo)}}"
                                         alt="{{$employee->description_name}}"/>
                                @endisset
                            @endif
                        </div>
                        <div>
                            <label for="photo">
                                <a type="button"
                                   class="hover:bg-primary hover:text-white text-primary ring-2 ring-primary p-2 rounded-full cursor-pointer">
                                    <x-icon name="camera" class="w-5 h-5 "></x-icon>
                                </a>
                                <input type="file" name="photo" id="photo" wire:model="photo" hidden/>
                            </label>
                            @error('photo') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-span-3 sm:col-span-4 mt-4">
                        <x-input-label for="employee_name">Nome</x-input-label>
                        <x-text-input type="text" id="employee_name" class="w-full"
                                      wire:model="name"></x-text-input>
                    </div>
                    <div class="col-span-3 sm:col-span-2 mt-4">
                        <x-input-label for="x_clinic_id">Código X-Clinic</x-input-label>
                        <x-text-input type="number" id="x_clinic_id" class="w-full"
                                      wire:model="x_clinic_id"></x-text-input>
                    </div>
                    <div class="col-span-3 sm:col-span-4 mt-4">
                        <x-input-label for="description_name">Nome Social (Pesquisa)</x-input-label>
                        <x-text-input type="text" id="description_name" class="w-full"
                                      wire:model="description_name"></x-text-input>
                    </div>
                    <div class="col-span-3 sm:col-span-4 mt-4 text-left">
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                               for="roles">Cargos</label>
                        <select id="roles" name="roles" class="rounded-lg shadow-sm border border-gray-300"
                                wire:model.live="role">
                            <option value="">Selecione</option>
                            @foreach($roles as $r)
                                <option value="{{$r->name}}">{{$r->name}}</option>
                            @endforeach
                        </select>
                        <a type="button"  wire:click="attachRole"
                           class="hover:bg-primary hover:text-white text-primary ring-2 ring-primary p-2 rounded-full cursor-pointer">
                            <x-icon name="plus" class="w-3 h-3"></x-icon>
                        </a>
                    </div>
                    <div class="col-span-3 sm:col-span-2 mt-4 text-left">
                        <span class="block font-medium text-sm text-gray-700 dark:text-gray-300">Cargos Atuais</span>
                        @isset($employee->roles)
                            @foreach($employee->roles as $er)
                                <span class="inline-flex items-center px-2 py-1 text-sm border border-primary rounded-lg text-primary">{{$er->name}}<a type="button" class="cursor-pointer" wire:click="detachRole('{{$er->name}}')"> <x-icon name="x" class="h-4 w-4"></x-icon> </a></span>
                            @endforeach
                        @endisset
                    </div>
                </div>

            </x-slot:content>
            <x-slot:footer>
                <div class="space-x-2">
                    <x-secondary-button x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-danger-button wire:click="delete">Excluir</x-danger-button>
                    <x-primary-button type="submit">Salvar</x-primary-button>
                </div>
            </x-slot:footer>
        </x-modal.dialog>
    </form>
</div>
