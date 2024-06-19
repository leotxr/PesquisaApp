<div class="py-6 mx-auto space-y-6 max-w-full sm:py-6" wire:poll.10000ms>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="px-4 py-6 bg-white rounded-lg shadow-md dark:bg-gray-800" wire:ignore>
            <h1>Pesquisas por dia</h1>
            <span class="text-xs font-light text-gray-500">Exibe o total de pesquisas em cada dia, exceto os dias em que não houveram atendimento.</span>
            <div class="h-24 bg-white" id="chartDays">

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
    <script type="module">

        var chartDaysOptions = {
            chart: {
                type: 'area',
                height: 250
            },
            series: [{
                name: 'Pesquisas/dia',
                data: @json($ratings_count)
            }],
            xaxis: {
                categories: @json($days)
            }
        }

        var chartDays = new ApexCharts(document.querySelector("#chartDays"), chartDaysOptions);

        chartDays.render();
    </script>
</div>