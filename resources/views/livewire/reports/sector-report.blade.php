<div>
    <div wire:loading>
        @livewire('templates.loading-screen')
    </div>
    <form wire:submit="search">
        <div class="p-2 bg-white shadow sm:p-4 sm:rounded-lg">
            <x-accordion>
                <x-slot name="title">
                    <div class="flex justify-start mx-2 font-bold text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/>
                        </svg>
                        <h1>Filtros</h1>
                    </div>
                </x-slot>
                <x-slot name="content">
                    <div class="max-w-full">
                        <div class="grid content-center grid-cols-2 gap-4 sm:grid-cols-5">
                            <div>
                                <label for="start_date"
                                       class="text-sm font-light text-gray-900 label">Data
                                    inicial</label>
                                <input type="date" wire:model='start_date' id="start_date"
                                       class="border-gray-300 input">
                            </div>
                            <div>
                                <label for="end_date"
                                       class="text-sm font-light text-gray-900 label">Data Final</label>
                                <input type="date" wire:model='end_date' id="end_date"
                                       class="border-gray-300 input">
                            </div>
                            <div>
                                <label for="submit"
                                       class="text-sm font-light text-gray-900 label">Gerar
                                    relatório</label>
                                <x-primary-button id="submit" type="submit">
                                    <x-icon name="refresh" class="w-5 h-5"></x-icon>
                                    <span>Buscar</span>
                                </x-primary-button>
                            </div>
                            @if($start_date)
                                <div>
                                    <label for="export"
                                           class="text-sm font-light text-gray-900 label">Exportar
                                    </label>
                                    <x-primary-button id="export" type="button" class="bg-green-800"
                                                      wire:click="export">
                                        <x-icon name="table" class="w-5 h-5"></x-icon>
                                        <span>Exportar</span>
                                    </x-primary-button>
                                </div>
                            @endif
                        </div>
                    </div>
                </x-slot>
            </x-accordion>
        </div>
    </form>
    <div>
        @include('admin.tables.table-setores')
    </div>

</div>
