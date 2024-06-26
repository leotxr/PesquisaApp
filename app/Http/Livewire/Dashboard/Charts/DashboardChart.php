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
    public $days = [];
    public $days_unformatted = [];
    public $ratings_count = [];
    public $dates_and_ratings = [];

    public function mount()
    {
        $this->getLastDaysWithCount(0, 10);

        $this->days = array_keys(array_reverse($this->dates_and_ratings));
        $this->ratings_count = array_values(array_reverse($this->dates_and_ratings));
    }

    public function refreshMe()
    {

    }


    public function getLastDaysWithCount(int $start_sub_days, int $end_sub_days)
    {
        $date = now()->subDays($start_sub_days);
        $count = Rating::where('data_req', $date->format('Y-m-d'))->count();

        if ($start_sub_days == $end_sub_days) return $this->dates_and_ratings;

        if ($count > 0) {
            $this->dates_and_ratings[$date->format('d/m')] = $count;
            //$this->days[] = $date;
            return $this->getLastDaysWithCount($start_sub_days + 1, $end_sub_days);
        } else return $this->getLastDaysWithCount($start_sub_days + 1, $end_sub_days + 1);
    }

    public function render()
    {
        $dias_atras = [today()->subDays(4), today()->subDays(3), today()->subDays(2), today()->subDays(1), today()->subDays(0)];
        $meses_atras = [today()->subMonthNoOverflow(4), today()->subMonthNoOverflow(3), today()->subMonthNoOverflow(2), today()->subMonthNoOverflow(1), today()->subMonthNoOverflow(0)];

        $colors = ['#f6ad55', '#fc8181', '#90cdf4', '#f6ad55', '#fc8181'];
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

        foreach ($dias_atras as $dia) {
            $columnChartDays = $chartDays->addColumn($dia->format('d/m/y'), Rating::whereDate('created_at', $dia)->count(), '#808080');
        }
        foreach ($meses_atras as $mes) {
            $columnChartMonths = $chartMonths->addColumn($mes->format('m/Y'), Rating::whereMonth('created_at', $mes->format('m'))->whereYear('created_at', $mes->format('Y'))->count(), '#808080');
        }


        $this->firstRun = false;

        return view('livewire.dashboard.charts.dashboard-chart')
            ->with(['columnChartDays' => $columnChartDays, 'columnChartMonths' => $columnChartMonths]);
    }
}
