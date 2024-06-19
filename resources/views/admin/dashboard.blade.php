<x-app-layout>
    <div class="py-2 ">
        <div class="mx-auto max-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b bg-base border-base-200">
                    @livewire('dashboard.dashboard-stats')
                    @livewire('dashboard.charts.dashboard-chart')
                    @livewire('dashboard.charts.sectors-chart')
                </div>
            </div>
        </div>
    </div>
    <script setup>
        console.log(ApexCharts);
    </script>
</x-app-layout>
