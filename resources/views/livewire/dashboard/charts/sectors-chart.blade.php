<div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8 sm:py-6">
    <div class="px-4 py-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h1>Avaliações por setores</h1>
        <span class="text-xs font-light text-gray-500">Exibe o total de avaliações para cada setor no mês atual.</span>
        <div class="h-56">
            <livewire:livewire-column-chart :column-chart-model="$columnChartSectors" />
        </div>
    </div>
</div>