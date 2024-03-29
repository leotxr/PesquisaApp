<x-app-layout id="dashboard">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Avaliação x Atendimento X-Clinic (Setor)
        </h2>
    </x-slot>

    <div class="py-2 text-center">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b bg-base border-base-200">
                    @livewire('reports.sector-report')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
