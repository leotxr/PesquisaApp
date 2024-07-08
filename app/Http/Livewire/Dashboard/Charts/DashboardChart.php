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
        //Chamada da função recursiva de dias anteriores. Informar o dia inicial para busca (hoje = 0) e o máximo de dias anteriores.
        //A variável max_check serve como limite para a função. Se caso em 60 tentativas o sistema não encontre pesquisas, ela é finalizada para que não
        //ocorra loops
        $this->getLastDaysWithCount(0, 20, 60);

        $this->days = array_keys(array_reverse($this->dates_and_ratings));
        $this->ratings_count = array_values(array_reverse($this->dates_and_ratings));
    }

    public function refreshMe()
    {

    }


    #   Função recursiva para buscar os dias anteriores que houveram pesquisas respondidas.
    #   Parametros:
    #   $start_sub_days = Dia inicial para busca de pesquisas. 0 = Hoje, 1 = Ontem ...
    #   $end_sub_days = Máximo de dias a serem mostrados.
    #   $max_check = Numero máximo de tentativas de busca.
    #   Retorno: Retorna um array contendo a data como chave e quantidade de pesquisas como valor. Exemplo: $array[$data] = $quantidade.
    public function getLastDaysWithCount(int $start_sub_days, int $end_sub_days, int $max_check)
    {
        $date = now()->subDays($start_sub_days); //Retorna a data atual (primeiro parametro informado, 0).

        $count = Rating::where('data_req', $date->format('Y-m-d'))->count(); //Retorna a quantidade de pesquisas respondidas na data recuperada

        if ($start_sub_days == $end_sub_days || $end_sub_days == $max_check) return $this->dates_and_ratings; // Verifica se as datas se igualaram ou atingiu o limite de execução.

        if ($count > 0) {

            $this->dates_and_ratings[$date->format('d/m')] = $count; //Se a contagem de pesquisas for maior que 0, adiciona a data como key do vetor, e o valor vinculado à essa chave.
            return $this->getLastDaysWithCount($start_sub_days + 1, $end_sub_days, $max_check + 1); //Executa a função novamente pulando para o próximo dia a ser testado.

            //Caso a contagem de pesquisas do dia seja 0, o sistema deve buscar em mais dias anteriores, então a variavel de fim é
            // somada porém a de inicio também é somada para que não seja verificada novamente.
        } else return $this->getLastDaysWithCount($start_sub_days + 1, $end_sub_days + 1, $max_check + 1);
    }

    public function render()
    {
        return view('livewire.dashboard.charts.dashboard-chart');
    }
}
