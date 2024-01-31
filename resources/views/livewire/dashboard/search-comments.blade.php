<div>
    <div class="h-1">
        <div wire:loading>
                <span class="absolute inline-flex w-24 h-1 animate-bar bg-sky-500"></span>
        </div>
    </div>
    
    <form wire:submit='render'>
        <div class="grid content-center gap-8 p-4 text-center bg-white sm:grid-cols-4">

            <div>
                <x-input-label for="date_1" class="label">
                    Data Inicial
                </x-input-label>
                <input wire:model='initial_date' id="date_1" name="initial_date" type="date"
                    class="input input-bordered">
            </div>
            <div>
                <x-input-label for="date_2" class="label">
                    Data Final
                </x-input-label>
                <input wire:model='final_date' id="date_2" name="final_date" type="date"
                    class="input input-bordered">
            </div>

            <div>
                <x-input-label for="search_status" class="label">
                    Classificação
                </x-input-label>
                <select wire:model='search_status' name="search_status" multiple size="3"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @foreach ($statuses as $status)
                    <option selected value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="p-4">
                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center"
                    type="button">Exportar <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg></button>
                <!-- Dropdown menu -->
                <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <button wire:click='export' class="block w-full px-4 py-2 hover:bg-gray-100">Excel</button>
                        </li>
                        <li>
                            <button wire:click='export' class="block w-full px-4 py-2 hover:bg-gray-100">PDF</button>
                        </li>
                    </ul>
                </div>
                <button type="submit"
                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2">Buscar</button>
            </div>

        </div>
    </form>


    <div>
        @isset($comments)
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="table" class="w-full text-sm text-left text-gray-500">

                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Comentário
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Médico/Técnico
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Enfermeira/USG
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Ação
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $comment)
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900">
                            {{ $comment->rating_id }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 hover:text-blue-600"
                            wire:click="showDetails({{$comment->rating_id}})" style="cursor: pointer">
                            {{ $comment->comentario }}
                        </th>
                        <td class="max-w-sm px-6 py-4 whitespace-pre-line">
                            @if ($comment->setor == 'ULTRA-SON' || $comment->setor == 'CARDIOLOGIA')
                            <b>
                                {{ $comment->livro_name }}</b>
                            @else
                            <b>{{ $comment->tec_name }}</b>
                            @endif

                        </td>
                        <td class="px-6 py-4">
                            @if ($comment->setor == 'ULTRA-SON' || $comment->setor == 'CARDIOLOGIA')
                            <b>
                                {{ $comment->us_name }}</b>
                            @else
                            <b>{{ $comment->enf_name }}</b>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex radio-group rating">
                                @foreach ($statuses as $status)
                                @php
                                $emojis = ['emoji-happy', 'emoji-sad', 'emoji-neutral'];
                                @endphp
                                <label for="status_{{$comment->rating_id}}_{{$status->id}}" style="cursor: pointer">
                                    <input type="radio" class="opacity-0" name="status_{{$comment->rating_id}}"
                                        id="status_{{$comment->rating_id}}_{{$status->id}}" value="{{$status->id}}"
                                        wire:click="setStatus({{$comment->rating_id}}, {{$status->id}})" />
                                    <x-icon name="{{$emojis[$status->id - 1]}}" class="w-8 h-8"></x-icon>
                                </label>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endforeach


                </tbody>

            </table>
        </div>
        @endisset
    </div>

    <div>
        @isset($rating)
        <x-modal.dialog wire:model="modalComment">

            <x-slot name="title">
                Informações da avaliação #{{$rating->id}}
            </x-slot>
            <x-slot name="content">

                <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                    <div class="flex flex-col pb-3">
                        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Nome do paciente</dt>
                        <dd class="text-lg font-semibold">{{$rating->pac_name}}</dd>
                    </div>
                    <div class="flex flex-col py-3">
                        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Avaliação Recepcionista</dt>
                        <dd class="text-lg font-semibold">{{$rating->recep_name}} - Nota: {{$rating->recep_rate}}</dd>
                    </div>
                    <div class="flex flex-col pt-3">
                        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Avaliação Clínica</dt>
                        <dd class="text-lg font-semibold">{{$rating->nota_clinica}}</dd>
                    </div>
                </dl>

            </x-slot>
            <x-slot name="footer">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">Fechar</x-secondary-button>
            </x-slot>
        </x-modal.dialog>
        @endisset
    </div>

</div>