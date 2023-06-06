<?php

namespace App\Http\Livewire\Dashboard\Charts;

use Livewire\Component;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\RadarChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use App\Models\Rating;

class DashboardChart extends Component
{
    public $firstRun = true;


    public function render()
    {
        $dias_atras = [today()->subDays(4), today()->subDays(3), today()->subDays(2), today()->subDays(1), today()->subDays(0)];
        $meses_atras = [today()->subMonths(4), today()->subMonths(3), today()->subMonths(2), today()->subMonths(1), today()->subMonths(0)];
        $colors = ['#f6ad55', '#fc8181', '#90cdf4', '#f6ad55', '#fc8181' ];
        //$valores = Term::whereIn('created_at', $dias_atras)->where('sector_id', 1)->get();

        $chartDays = LivewireCharts::columnChartModel()
            ->setTitle('Pesquisas Realizadas por dia')
            ->setAnimated($this->firstRun)
            ->setLegendVisibility(false)
            ->withDataLabels(false)
            ->setColors(['#0080ff', '#288bed', '#8abef2', '#1863f0', '#78a3f5']);

        $chartMonths = LivewireCharts::columnChartModel()
            ->setTitle('Pesquisas Realizadas por mês')
            ->setAnimated($this->firstRun)
            ->setLegendVisibility(false)
            ->withDataLabels(false)
            ->setColors(['#0080ff', '#288bed', '#8abef2', '#1863f0', '#78a3f5']);

            foreach($dias_atras as $dia)
            {
                $columnChartDays = $chartDays->addColumn($dia->format('d/m/y'), Rating::whereDate('created_at', $dia)->count(), '#808080');
            }
            foreach($meses_atras as $mes)
            {
                $columnChartMonths = $chartMonths->addColumn($mes->format('m/Y'), Rating::whereMonth('created_at', $mes)->count(), '#808080');
            }
            

            $this->firstRun = false;

        return view('livewire.dashboard.charts.dashboard-chart')
            ->with(['columnChartDays' => $columnChartDays, 'columnChartMonths' => $columnChartMonths]);
    }
}
