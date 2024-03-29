<div class="py-6 mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8 sm:py-6" wire:poll.10000ms>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="px-4 py-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h1>Pesquisas por dia</h1>
            <span class="text-xs font-light text-gray-500">Exibe o total de pesquisas respondidas no dia.</span>
            <div class="h-56 bg-white">
                <livewire:livewire-column-chart :column-chart-model="$columnChartDays" />
            </div>
        </div>
        <div class="px-4 py-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h1>Pesquisas por mês</h1>
            <span class="text-xs font-light text-gray-500">Exibe o total de pesquisas respondidas no mês atual.</span>
            <div class="h-56 bg-white">
                <livewire:livewire-column-chart :column-chart-model="$columnChartMonths" />
            </div>
        </div>
    </div>
</div>