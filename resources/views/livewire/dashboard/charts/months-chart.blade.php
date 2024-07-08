<div class="py-6 mx-auto space-y-6 max-w-full sm:py-6">
    <div class="px-4 py-6 bg-white rounded-lg shadow-md dark:bg-gray-800" wire:ignore>
        <h1>Pesquisas por mês</h1>
        <span class="text-xs font-light text-gray-500">Exibe o total de pesquisas em cada mês.</span>
        <div class="h-24 bg-white" id="chartMonths">

        </div>
    </div>

    <script type="module">
        //CHART COM AS PESQUISAS POR MES
        var chartMonthsOptions = {
            chart: {
                type: 'bar',
                height: 250,
                zoom: {
                    enabled: true,
                    type: 'x',
                    autoScaleYaxis: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '80%'
                },
            },
            series: [{
                name: 'Pesquisas/dia',
                data: @json($ratings_count)
            }],
            xaxis: {
                categories: @json($months),
                //tickPlacement: "on",
                stepSize: 10,

            },

        }

        var chartMonths = new ApexCharts(document.querySelector("#chartMonths"), chartMonthsOptions);

        chartMonths.render();
    </script>
</div>
