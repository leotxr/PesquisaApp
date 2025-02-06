<x-app-layout id="dashboard">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Avaliação x Atendimento X-Clinic
        </h2>
    </x-slot>
    <!--
    <div class="py-2 text-center">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b bg-base border-base-200">
                    
                </div>
            </div>
        </div>
    </div>
-->

    <body>
        <div class="p-2 bg-white shadow sm:p-4 sm:rounded-lg">
            <x-accordion>
                <x-slot name="title">
                    <div class="flex justify-start mx-2 font-bold text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                        </svg>
                        <h1>Filtros</h1>
                    </div>
                </x-slot>
                <x-slot name="content">
                    <div class="max-w-full">
                        <div class="grid content-center grid-cols-2 gap-4 sm:grid-cols-5">
                            <div>
                                <label for="start_date" class="text-sm font-light text-gray-900 label">Data
                                    inicial</label>
                                <input type="date" id="start_date" class="border-gray-300 input">
                            </div>
                            <div>
                                <label for="end_date" class="text-sm font-light text-gray-900 label">Data
                                    Final</label>
                                <input type="date" id="end_date" class="border-gray-300 input">
                            </div>
                            <div>
                                <label for="submit" class="text-sm font-light text-gray-900 label">Gerar
                                    relatório</label>
                                <x-primary-button id="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                    <span>Buscar</span>
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </x-slot>
            </x-accordion>
        </div>
        <div>
            <div class="p-2 bg-white my-2 rounded-lg shadow">
                <h2 class="text-2xl font-bold">Enfermagem</h2>
            </div>
            <table id="tabela-nurses">
            <x-table>
                <x-slot:head>
                    <x-table.heading>Funcionário</x-table.heading>
                    <x-table.heading>Avaliações Pesquisa</x-table.heading>
                    <x-table.heading>Atendimentos X-Clinic</x-table.heading>
                    <x-table.heading>Diferença</x-table.heading>
                </x-slot:head>
                <x-slot:body>
                    <tbody>
                    </tbody>
                </x-slot:body>
            </x-table>
            </table>
        </div>
    </body>
    <script>
        $("#submit").click(function() {
            buscarDados();
        });

        function setEnfermeiras(data) {
            $('#tabela-nurses tbody').empty();
            console.log('limpou tabela');
            // Iterando sobre os dados e criando as linhas
            data.forEach(function(nurse) {
                console.log('montando linha');
                // Montando a linha da tabela
                let row = '<tr>';
                row += '<td>' + nurse.name + '</td>';
                row += '<td>' + nurse.count + '</td>';
                row += '<td>' + nurse.x_clinic_count + '</td>';
                row += '<td>' + nurse.avg + '%</td>';
                row += '</tr>';

                // Adicionando a linha na tabela
                $('#tabela-nurses tbody').append(row);
            });
        }

        function setTabelas() {

        }

        function buscarDados() {

            dataInicio = $("#start_date").val();
            dataFim = $("#end_date").val();
            data = {
                "dataInicio": dataInicio,
                "dataFim": dataFim
            }
            const url = "{{ route('relatorios/funcionariosetor') }}";

            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                success: function(response) {
                    res = JSON.parse(response);
                    console.log(res.enfermeiras);
                    setEnfermeiras(res.enfermeiras);

                },
                error: function(xhr, status, error) {
                    console.error('Erro ao gerar o PDF:', error);
                }
            });
        }
    </script>
</x-app-layout>
