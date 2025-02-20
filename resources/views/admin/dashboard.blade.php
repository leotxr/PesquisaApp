<x-app-layout>
    <div class="py-2 ">
        <div class="mx-auto max-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b bg-base border-base-200">
                    @livewire('dashboard.dashboard-stats')
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="col-span-2 sm:col-span-2">
                            @livewire('dashboard.charts.dashboard-chart')
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            @livewire('dashboard.charts.months-chart')
                        </div>
                    </div>
                    @livewire('dashboard.charts.sectors-chart')
                    @livewire('dashboard.charts.atendimento-chart')
                </div>
            </div>
        </div>
    </div>
    <script setup>
        console.log(ApexCharts);
    </script>
</x-app-layout>
