<div class="space-y-4">
    <x-table>
        <x-slot name="head">
            <x-table.heading>Data</x-table.heading>
            <x-table.heading>Paciente</x-table.heading>
            <x-table.heading>Recepcionista</x-table.heading>
            <x-table.heading>Nota</x-table.heading>
            @if(in_array('ULTRA-SON', $selectedSector) || in_array('CARDIOLOGIA', $selectedSector))
            <x-table.heading>Médico / Setor
            </x-table.heading>
            <x-table.heading>Nota</x-table.heading>
            <x-table.heading>Recepcionista USG
            </x-table.heading>
            <x-table.heading>Nota</x-table.heading>
            @else
            <x-table.heading>Setor
        </x-table.heading>
            <x-table.heading>Técnico</x-table.heading>
            <x-table.heading>Nota</x-table.heading>
            <x-table.heading>Enfermeira</x-table.heading>
            <x-table.heading>Nota</x-table.heading>
            @endif
        </x-slot>

        <x-slot name="body">
            @foreach ($data as $protocols)
            <x-table.row>
                <x-table.cell>{{ $protocols->data_req ?? '?' }}</x-table.cell>
                <x-table.cell>{{ $protocols->pac_name ?? '?' }}</x-table.cell>
                <x-table.cell>{{ $protocols->recep_name ?? '?' }}</x-table.cell>
                <x-table.cell>{{ $protocols->recep_rate ?? '?' }}</x-table.cell>
                @if(in_array('ULTRA-SON', $selectedSector) || in_array('CARDIOLOGIA', $selectedSector))
                <x-table.cell>{{ $protocols->livro_name ?? '?' }}</x-table.cell>
                <x-table.cell>{{ $protocols->livro_rate ?? '?' }}</x-table.cell>
                <x-table.cell>{{ $protocols->us_name ?? '?' }}</x-table.cell>
                <x-table.cell>{{ $protocols->us_rate ?? '?' }}</x-table.cell>
                @else
                <x-table.cell>{{ $protocols->livro_name ?? '?' }}</x-table.cell>
                <x-table.cell>{{ $protocols->tec_name ?? '?' }}</x-table.cell>
                <x-table.cell>{{ $protocols->livro_rate ?? '?' }}</x-table.cell>
                <x-table.cell>{{ $protocols->enf_name ?? '?' }}</x-table.cell>
                <x-table.cell>{{ $protocols->enf_rate ?? '?' }}</x-table.cell>
                @endif
            </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
   

</div>