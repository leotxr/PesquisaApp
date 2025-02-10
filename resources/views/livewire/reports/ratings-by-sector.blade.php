<div>
    <div>
        <div class="p-2 bg-white my-2 rounded-lg shadow">
            <h2 class="text-2xl font-bold">Atendimento por setores</h2>
        </div>
        <x-table>
            <x-slot:head>
                <x-table.heading>Setor</x-table.heading>
                <x-table.heading>Total de Avaliações</x-table.heading>
                <x-table.heading>Positivas</x-table.heading>
                <x-table.heading>Regulares</x-table.heading>
                <x-table.heading>Negativas</x-table.heading>
                <x-table.heading>Satisfação</x-table.heading>
            </x-slot:head>
            <x-slot:body>
                @foreach($faturas as $fatura)
                    <x-table.row>
                        <x-table.cell>{{$fatura->setor}}</x-table.cell>
                        <x-table.cell>{{$fatura->total->count()}}</x-table.cell>
                        <x-table.cell>{{$fatura->total->where('livro_rate', '>', 3)->count()}}</x-table.cell>
                        <x-table.cell>{{$fatura->total->where('livro_rate', '=', 3)->count()}}</x-table.cell>
                        <x-table.cell>{{$fatura->total->where('livro_rate', '<', 3)->count()}}</x-table.cell>
                        <x-table.cell>

                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot:body>
        </x-table>
    </div>
</div>
