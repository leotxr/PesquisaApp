<?php

namespace App\Http\Livewire\Dashboard\Charts;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Fatura;
use Illuminate\Support\Facades\DB;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;


class SectorsChart extends Component
{
    public $sectors = [];
    public $sector_count = [];

    public function mount()
    {
        //Chamada da função recursiva de dias anteriores. Informar o dia inicial para busca (hoje = 0) e o máximo de dias anteriores.
        //A variável max_check serve como limite para a função. Se caso em 60 tentativas o sistema não encontre pesquisas, ela é finalizada para que não
        //ocorra loops
        $this->getSectorsMonth();
    }
    public function getSectorsMonth(): void
    {
        $date = today();

        $this->sectors = DB::table('faturas')
        ->whereMonth('created_at', $date->format('m'))
        ->whereYear('created_at', $date->format('Y'))
        ->select('setor')
        ->distinct()
        ->orderBy('setor')
        ->get();

        foreach($this->sectors as $sector)
        {
            $this->sector_count[] = DB::table('faturas')
            ->whereMonth('created_at', $date->format('m'))
            ->whereYear('created_at', $date->format('Y'))
            ->where('setor', '=', $sector->setor)
            ->count();
        }

    }

    public function render()
    {
        return view('livewire.dashboard.charts.sectors-chart');
    }
}
