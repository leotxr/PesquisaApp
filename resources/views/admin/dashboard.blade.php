<x-app-layout id="dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 text-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-base-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-base border-b border-base-200">
                    <div class="flex flex-wrap justify-center">

                        @livewire('dashboard.dashboard-stats', ['title' => 'Pesquisas respondidas hoje', 'value' => $day, 'description' => 'abc'])
                        @livewire('dashboard.dashboard-stats', ['title' => 'Pesquisas respondidas no mês', 'value' => $month, 'description' => 'abc'])
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
