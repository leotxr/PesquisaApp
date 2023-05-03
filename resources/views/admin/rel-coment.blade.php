<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Relatório de Comentários por Período') }}
        </h2>
    </x-slot>

    <div class="py-2">
        @livewire('dashboard.search-comments')
    </div>
</x-app-layout>

