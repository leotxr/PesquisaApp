<div class="py-6 mx-auto space-y-6 max-w-full sm:py-6">
    <div class="px-4 py-6 bg-white rounded-lg shadow-md dark:bg-gray-800" wire:ignore>
        <h1>Pesquisas por dia</h1>
        <span class="text-xs font-light text-gray-500">Exibe o total de pesquisas em cada dia, exceto os dias em que não houveram atendimento.</span>
        <div class="h-24 bg-white" id="chartDays">

        </div>
    </div>

    <script type="module">
        //CHART COM AS PESQUISAS POR DIA
        var chartDaysOptions = {
            chart: {
                type: 'area',
                height: 250,
                zoom: {
                    enabled: true,
                    type: 'x',
                    autoScaleYaxis: false
                },
                toolbar: {
                    show: true,
                    tools: {
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true
                    },
                    autoSelected: 'pan'
                },
            },
            series: [{
                name: 'Pesquisas/dia',
                data: @json($ratings_count)
            }],
            xaxis: {
                categories: @json($days),
                tickPlacement: "on",
                stepSize: 10,

            },

        }

        var chartDays = new ApexCharts(document.querySelector("#chartDays"), chartDaysOptions);

        chartDays.render();

    </script>
</div>