<div>
    <div class="p-2 bg-white my-2 rounded-lg shadow">
        <h2 class="text-2xl font-bold">Satisfação por setores</h2>
    </div>
    <x-table>
        <x-slot:head>
            <x-table.heading>Setor</x-table.heading>
            <x-table.heading>Quantidade Avaliações</x-table.heading>
            <x-table.heading>Positivas</x-table.heading>
            <x-table.heading>Regulares</x-table.heading>
            <x-table.heading>Negativas</x-table.heading>
            <x-table.heading>Satisfação</x-table.heading>
        </x-slot:head>
        <x-slot:body>
            @foreach($faturas as $fatura)
                <x-table.row>
                    <x-table.cell>{{$fatura->setor}}</x-table.cell>
                    <x-table.cell>{{$fatura->total}}</x-table.cell>
                    <x-table.cell>{{$fatura->otimo}}</x-table.cell>
                    <x-table.cell>{{$fatura->regular}}</x-table.cell>
                    <x-table.cell>{{$fatura->ruim}}</x-table.cell>
                    @if($fatura->total > 0 || $fatura->otimo > 0)
                        <x-table.cell>{{number_format($fatura->otimo / $fatura->total *
                                100, 2, '.', '')}}%
                        </x-table.cell>
                    @endif
                </x-table.row>
            @endforeach
        </x-slot:body>
    </x-table>
</div>
