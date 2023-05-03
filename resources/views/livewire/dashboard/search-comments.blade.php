<div>
    <form wire:submit.prevent='search'>
        <div class="grid sm:grid-cols-4 gap-8 text-center content-center bg-white p-4">

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
                <input wire:model='final_date' id="date_2" name="final_date" type="date" class="input input-bordered">
            </div>

            <div>
                <x-input-label for="search_status" class="label">
                    Classificação
                </x-input-label>
                <select wire:model='search_status' name="search_status" multiple size="3"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($statuses as $status)
                        <option selected value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="p-4">
                <button type="submit" class="btn">Buscar</button>
            </div>

        </div>
    </form>

    <div wire:loading>
        Aguarde. Carregando Comentários...
    </div>


    <div>
        @isset($comments)
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div>
                <div class="flex">
                    <form method="GET" action="{{route('export.comments')}}">
                        <button class="btn btn-success m-4" type="submit">
                            Excel
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </button>
                    </form>
                    <button class="btn btn-success m-4" onclick="window.print()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        Imprimir</button>
                    <button class="btn m-4" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>

                        Salvar</button>
                        --}}
                    </div>
                </div>
                <table id="table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
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
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ação
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $comment->comentario }}
                                </th>
                                <td class="px-6 py-4 whitespace-pre-line max-w-sm">
                                    @if ($comment->setor == 'ULTRA-SON' || $comment->setor == 'CARDIOLOGIA')
                                        <b>
                                            {{ $comment->livro_name }}</b>
                                    @else
                                        <b>{{ $comment->tec_name }}</b>
                                    @endif

                        </td>
                        <td class="px-6 py-4">
                            @if($comment->setor == 'ULTRA-SON' || $comment->setor == 'CARDIOLOGIA' ) <b>
                                {{$comment->us_name}}</b> @else <b>{{$comment->enf_name}}</b> @endif
                        </td>
                        <td class="px-6 py-4">
                            {{$comment->status_comentario_id ?? 'Sem Status'}}
                        </td>
                        <td class="px-6 py-4 dropdown dropdown-left dropdown-end">
                            <div class="flex radio-group">
                                @foreach($statuses as $status)
                                @livewire('dashboard.select-status', ['comment' => $comment->rating_id, 'status' =>
                                $status], key($comment->rating_id))
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

    <script>
        function html_table_to_excel(type) {
            var data = document.getElementById('table');
    
            var file = XLSX.utils.table_to_book(data, {
                sheet: "sheet1"
            });
    
            XLSX.write(file, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            });
            
            XLSX.writeFile(file, 'relatorio_comentarios_' + '.' + type);
        }
    
        const export_button = document.getElementById('export_table');
    
        export_button.addEventListener('click', () => {
            html_table_to_excel('xlsx');
        });
    </script>

</div>
