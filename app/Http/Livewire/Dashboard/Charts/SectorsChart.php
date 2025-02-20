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
        $this->getLastMonthsWithCount(0, 6, 10);

        $this->months = array_keys(array_reverse($this->months_and_ratings));
        $this->ratings_count = array_values(array_reverse($this->months_and_ratings));
    }
    public function getLastMonthsWithCount(int $start_sub_days, int $end_sub_days, int $max_check)
    {
        $date = date('m');
        $year = date('y');

        $sectors = DB::table('faturas')
        ->select('setor')
        ->distinct()
        ->orderBy('setor')
        ->get();;

        dd($sectors);
    }

    public function render()
    {
        return view('livewire.dashboard.charts.sectors-chart');
    }
}
