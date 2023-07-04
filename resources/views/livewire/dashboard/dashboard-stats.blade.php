<div>

    <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
        {{--
        <div class="p-2 bg-white shadow sm:p-4 sm:rounded-lg">
            <x-accordion>
                <x-slot name="title">
                    <div class="flex justify-start mx-2 font-bold text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                        </svg>
                        <h1>Filtros<h1>
                    </div>
                </x-slot>
                <x-slot name="content">
                    <div class="max-w-xl">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="initial_date"
                                    class="text-sm font-light text-gray-900 label">Data
                                    inicial</label>
                                <input type="date" wire:model='initial_date' id="initial_date"
                                    class="border-gray-300 input">
                            </div>
                            <div>
                                <label for="final_date"
                                    class="text-sm font-light text-gray-900 label">Data Final</label>
                                <input type="date" wire:model='final_date' id="final_date"
                                    class="border-gray-300 input">
                            </div>
                        </div>
                    </div>
                </x-slot>
            </x-accordion>
        </div>
        --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2" wire:poll.10000ms>

            <x-single-stat>
                <x-slot name="title">Pesquisas Realizadas Hoje</x-slot>
                <x-slot name="value">{{$today}}</x-slot>
                <x-slot name="statistic"></x-slot>
                <x-slot name="description">{{today()->format('d/m/Y')}}</x-slot>
            </x-single-stat>
            <x-single-stat>
                <x-slot name="title">Pesquisas Este mês</x-slot>
                <x-slot name="value">{{$month}}</x-slot>
                <x-slot name="statistic"></x-slot>
                <x-slot name="description">{{today()->format('m/Y')}}</x-slot>
            </x-single-stat>

        </div>

    </div>
</div>