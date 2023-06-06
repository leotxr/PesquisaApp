<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Relatório de Avaliação por Setor') }}
        </h2>
    </x-slot>

    <div class="m-4 shadow-sm">
        <div class="max-w-full px-12 justify-items-center">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div>
                    @livewire('reports.sectors-report')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
