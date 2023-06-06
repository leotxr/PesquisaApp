<div class="justify-center">
    <form wire:submit.prevent='render'>
        @csrf
        <div class="p-2 bg-white shadow sm:p-4 dark:bg-gray-800 sm:rounded-lg">
            <x-accordion>
                <x-slot name="title">
                    <div class="flex justify-start mx-2 font-bold text-gray-900 dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                        </svg>
                        <h1>Filtros<h1>
                    </div>
                </x-slot>
                <x-slot name="content">
                    <div class="max-w-full">
                        <div class="grid content-center grid-cols-2 gap-4 sm:grid-cols-5">
                            <div>
                                <label for="initial_date"
                                    class="text-sm font-light text-gray-900 label dark:text-gray-50">Data
                                    inicial</label>
                                <input type="date" wire:model.defer='initial_date' id="initial_date"
                                    class="border-gray-300 input">
                            </div>
                            <div>
                                <label for="final_date"
                                    class="text-sm font-light text-gray-900 label dark:text-gray-50">Data Final</label>
                                <input type="date" wire:model.defer='final_date' id="final_date"
                                    class="border-gray-300 input">
                            </div>
                            <div>
                                <label for="filter"
                                    class="text-sm font-light text-gray-900 label dark:text-gray-50">Filtros</label>
                                <x-primary-button id="filter" wire:click='searchFilters()'>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                                    </svg>
                                    <span>Filtros<span>
                                </x-primary-button>
                            </div>
                            <div>
                                <label for="submit"
                                    class="text-sm font-light text-gray-900 label dark:text-gray-50">Gerar
                                    relatório</label>
                                <x-primary-button id="submit" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                    <span>Buscar<span>
                                </x-primary-button>
                            </div>
                            <div class="p-4">
                                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="button">Exportar <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg></button>
                                <div id="dropdown"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownDefaultButton">
                                        <li>
                                            <button wire:click='export'
                                                class="block w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Excel</button>
                                        </li>
                                        <li>
                                            <button wire:click='export'
                                                class="block w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">PDF</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-slot>
            </x-accordion>

        </div>
        <div class="w-full p-6">
            <div class="border responsive">
                @include('admin.tables.table-sector-report')

            </div>
        </div>

        {{--MODAL--}}
        <x-modal.dialog wire:model.defer="modalFilters">
            <x-slot name="title">
                Filtros de pesquisa
            </x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="p-4 border-2">
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Setores Radiologia</h3>
                        @foreach($setoresRadiologia as $radiologia)
                        <ul
                            class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="status-{{$radiologia}}" type="checkbox" name="selectedSector[]"
                                        value="{{$radiologia}}" wire:model='selectedSector'
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="status-{{$radiologia}}"
                                        class="w-full py-3 ml-2 text-xs font-medium text-gray-900 dark:text-gray-300">{{$radiologia}}</label>
                                </div>
                            </li>
                        </ul>
                        @endforeach
                    </div>
                    <div class="p-4 border-2">
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Ressonância / Tomografia</h3>
                        @foreach($setoresRMTC as $rmtc)
                        <ul
                            class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="status-{{$rmtc}}" type="checkbox" name="selectedSector[]"
                                        value="{{$rmtc}}" wire:model='selectedSector'
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="status-{{$rmtc}}"
                                        class="w-full py-3 ml-2 text-xs font-medium text-gray-900 dark:text-gray-300">{{$rmtc}}</label>
                                </div>
                            </li>
                        </ul>
                        @endforeach
                    </div>
                    <div class="p-4 border-2">
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Ultra-Son / Cardiologia</h3>
                        @foreach($setoresUSG as $usg)
                        <ul
                            class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                <div class="flex items-center pl-3">
                                    <input id="status-{{$usg}}" type="checkbox" name="selectedSector[]" value="{{$usg}}"
                                        wire:model='selectedSector'
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="status-{{$usg}}"
                                        class="w-full py-3 ml-2 text-xs font-medium text-gray-900 dark:text-gray-300">{{$usg}}</label>
                                </div>
                            </li>
                        </ul>
                        @endforeach
                    </div>

                </div>

            </x-slot>
            <x-slot name="footer">
                <x-primary-button x-on:click="$dispatch('close')">Selecionar</x-primary-button>
            </x-slot>

        </x-modal.dialog>
    </form>
</div>