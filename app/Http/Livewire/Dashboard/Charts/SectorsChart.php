<?php

namespace App\Http\Livewire\Dashboard\Charts;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Fatura;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;


class SectorsChart extends Component
{
    public $firstRun = true;

    public function render()
    {
        $setores = ['DENSITOMETRIA', 'MAMOGRAFIA', 'RAIOSX', 'MAPA', 'ELETROCARDIOGRAMA', 'TC-ODONTOLOGICA', 'RX-ODONTOLOGICA',
        'TOMOGRAFIA', 'RESSONANCIA', 'ULTRA-SON', 'CARDIOLOGIA'];

        $chartSetores = LivewireCharts::columnChartModel()
            ->setTitle('Avaliações por Setor/Mês')
            ->setAnimated($this->firstRun)
            ->setLegendVisibility(false)
            ->withDataLabels(true)
            ->setColors(['#0080ff', '#288bed', '#8abef2', '#1863f0', '#78a3f5']);

            foreach($setores as $setor)
            {
                $columnChartSetores = $chartSetores->addColumn($setor, Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')->where('faturas.setor', '=', $setor)->whereMonth('ratings.data_req', date('m'))->count(), '#808080');
            }

        $this->firstRun = false;

        return view('livewire.dashboard.charts.sectors-chart')
            ->with(['columnChartSectors' => $columnChartSetores]);
    }
}
