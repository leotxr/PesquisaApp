<div>
    <div class="p-2 bg-white my-2 rounded-lg shadow">
        <h2 class="text-2xl font-bold">Atendimento por setores</h2>
    </div>
    <x-table>
        <x-slot:head>
            <x-table.heading>Setor</x-table.heading>
            <x-table.heading>Avaliações Pesquisa</x-table.heading>
            <x-table.heading>Atendimentos X-Clinic</x-table.heading>
            <x-table.heading>Diferença</x-table.heading>
        </x-slot:head>
        <x-slot:body>
            @foreach($faturas as $fatura)
                <x-table.row>
                    <x-table.cell>{{$fatura->setor}}</x-table.cell>
                    <x-table.cell>{{$fatura->total}}</x-table.cell>
                    <x-table.cell>{{$fatura->x_clinic}}</x-table.cell>

                </x-table.row>
            @endforeach
        </x-slot:body>
    </x-table>
</div>
