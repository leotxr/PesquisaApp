<head>
    <style type="text/css">
        @media print {
            body * {
                visibility: hidden;
            }

            #table,
            #table * {
                visibility: visible;
            }

            #table {
                position: absolute;
                top: 0;
                left: 0;
            }

        }
    </style>
</head>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="grid sm:grid-cols-2 gap-2">
                    <button class="btn btn-success my-2" id="export_table">
                        Excel
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </button>
                    <button class="btn btn-success my-2" onclick="window.print()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        Imprimir</button>
                </div>
                <form method="POST" action="{{ route('editComent') }}">
                    @csrf
                    <div class="overflow-x-auto">
                        <table id="table" class="table w-full text-center">
                            <!-- head -->
                            <!-- TABELA RELATORIO MEDICO -->
                            <thead>
                                <tr>
                                    @isset($relcoment)
                                        <th>ID</th>
                                        <th>Data</th>
                                        <th>Comentario</th>
                                        <th>Nota Clínica</th>
                                        <th>Classificação</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($relcoment as $result)
                                        <tr>
                                            <td><input type="number" name="id[]" value="{{ $result->id }}" hidden>
                                            </td>
                                            <td>{{ date('d/M/y', strtotime($result->data_req)) }}</td>
                                            <td class="whitespace-pre-line max-w-sm">{{ $result->comentario }} @if($result->setor == 'ULTRA-SON' || $result->setor == 'CARDIOLOGIA' ) <b>. {{$result->livro_name}}</b> @else <b>. {{$result->tec_name}}</b> @endif</td>
                                            <td>{{ $result->nota_clinica }}</td>
                                            <td>
                                                <select name="class_comentario[]"
                                                    class="select select-bordered w-full max-w-xs">
                                                    <option value="{{ $result->class_comentario }}">
                                                        @if ($result->class_comentario == 1)
                                                            Positivo
                                                        @elseif($result->class_comentario == 2)
                                                            Sugestão
                                                        @elseif($result->class_comentario == 0)
                                                            Negativo
                                                        @else
                                                            Oculto
                                                        @endif
                                                    </option>
                                                    <option value="1">Positivo</option>
                                                    <option value="2">Sugestão</option>
                                                    <option value="0">Negativo</option>
                                                    <option value="3">Oculto</option>
                                                </select>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    @endisset
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-success gap-2 mb-5">
                        Salvar
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15M9 12l3 3m0 0l3-3m-3 3V2.25" />
                        </svg>

                    </button>
                </form>
            </div>
        </div>
    </div>
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