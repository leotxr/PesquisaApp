<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <button class="btn btn-success gap-2 mb-5" id="export_table">
                    Excel
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </button>

                <div class="overflow-x-auto">
                    <table id="table" class="table w-full">
                        <!-- head -->
                        <!-- TABELA DO RELATORIO GERAL -->
                        <thead>
                            <tr>
                                @isset($relgeral)
                                <th></th>
                                <th>Data</th>
                                <th>Paciente</th>
                                <th>Atendente</th>
                                <th>Nota</th>
                                <th>Recepcionista</th>
                                <th>Nota</th>
                                <th>Livro</th>
                                <th>Nota</th>
                                <th>Setor</th>
                                <th>Ultrimagem</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($relgeral as $result)
                            <tr>
                                <th></th>
                                <td>{{$result->DATA}}</td>
                                <td>{{$result->PACIENTE}}</td>
                                <td>{{$result->ATENDENTE}}</td>
                                <td>{{$result->NOTA_ATENDENTE}}</td>
                                <td>{{$result->RECEPCIONISTA}}</td>
                                <td>{{$result->NOTA_RECEPCIONISTA}}</td>
                                <td>{{$result->LIVRO}}</td>
                                <td>{{$result->NOTA_LIVRO}}</td>
                                <td>{{$result->SETOR}}</td>
                                <td>{{$result->ULTRIMAGEM}}</td>
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
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Média clínica</th>
                                <th>{{$avg = number_format($avg, 2,'.','')}}</th>
                                @endisset
                            </tr>
                        </thead>
                    </table>
                </div>
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

        const date = new Date();
        XLSX.writeFile(file, 'relatorio_geral_' + date.toDateString() + '.' + type);
    }

    const export_button = document.getElementById('export_table');

    export_button.addEventListener('click', () => {
        html_table_to_excel('xlsx');
    });
</script>
