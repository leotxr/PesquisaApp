<div class="space-y-4">

    <div>
        <div class="mt-4">
            <x-text-input type="text" wire:model='search' placeholder="Buscar avaliações...">
            </x-text-input>
        </div>
    </div>
    {{$data->links()}}
    <x-table>
        <x-slot name="head">
            <x-table.heading sortable wire:click="sortBy('ratings.data_req')"
                :direction="$sortField === 'ratings.data_req' ? $sortDirection : null">Data</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('ratings.pac_name')"
                :direction="$sortField === 'ratings.pac_name' ? $sortDirection : null">Paciente</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('ratings.recep_name')"
                :direction="$sortField === 'ratings.recep_name' ? $sortDirection : null">Recepcionista</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('ratings.recep_rate')"
                :direction="$sortField === 'ratings.recep_rate' ? $sortDirection : null">Nota</x-table.heading>
            @if(in_array('ULTRA-SON', $selectedSector) || in_array('CARDIOLOGIA', $selectedSector))
            <x-table.heading sortable wire:click="sortBy('faturas.livro_name')"
                :direction="$sortField === 'faturas.livro_name' ? $sortDirection : null">Médico / Setor
            </x-table.heading>
            <x-table.heading sortable wire:click="sortBy('faturas.livro_rate')"
                :direction="$sortField === 'faturas.livro_rate' ? $sortDirection : null">Nota</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('faturas.us_name')"
                :direction="$sortField === 'faturas.us_name' ? $sortDirection : null">Recepcionista USG
            </x-table.heading>
            <x-table.heading sortable wire:click="sortBy('faturas.us_rate')"
                :direction="$sortField === 'faturas.us_rate' ? $sortDirection : null">Nota</x-table.heading>
            @else
            <x-table.heading sortable wire:click="sortBy('faturas.livro_name')"
            :direction="$sortField === 'faturas.livro_name' ? $sortDirection : null">Setor
        </x-table.heading>
            <x-table.heading sortable wire:click="sortBy('faturas.tec_name')"
                :direction="$sortField === 'faturas.tec_name' ? $sortDirection : null">Técnico</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('faturas.livro_rate')"
                :direction="$sortField === 'faturas.livro_rate' ? $sortDirection : null">Nota</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('faturas.enf_name')"
                :direction="$sortField === 'faturas.enf_name' ? $sortDirection : null">Enfermeira</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('faturas.enf_rate')"
                :direction="$sortField === 'faturas.enf_rate' ? $sortDirection : null">Nota</x-table.heading>
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
    {{$data->links()}}

</div>