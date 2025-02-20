<?php

namespace App\Http\Livewire\Dashboard\Charts;

use App\Models\Rating;
use Livewire\Component;

class MonthsChart extends Component
{
    public $months = [];
    public $months_unformatted = [];
    public $ratings_count = [];
    public $months_and_ratings = [];

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
        $date = today()->subMonthNoOverflow($start_sub_days); //Retorna a data atual (primeiro parametro informado, 0).

        $count = Rating::whereMonth('data_req', $date->format('m'))->whereYear('data_req', $date->format('Y'))->where('finalizado', '=', 1)->count(); //Retorna a quantidade de pesquisas respondidas na data recuperada

        if ($start_sub_days == $end_sub_days || $end_sub_days == $max_check) return $this->months_and_ratings; // Verifica se as datas se igualaram ou atingiu o limite de execução.

        if ($count > 0) {

            $this->months_and_ratings[$date->format('m')] = $count; //Se a contagem de pesquisas for maior que 0, adiciona a data como key do vetor, e o valor vinculado à essa chave.
            return $this->getLastMonthsWithCount($start_sub_days + 1, $end_sub_days, $max_check + 1); //Executa a função novamente pulando para o próximo dia a ser testado.

            //Caso a contagem de pesquisas do dia seja 0, o sistema deve buscar em mais dias anteriores, então a variavel de fim é
            // somada porém a de inicio também é somada para que não seja verificada novamente.
        } else return $this->getLastMonthsWithCount($start_sub_days + 1, $end_sub_days + 1, $max_check + 1);
    }

    public function render()
    {
        return view('livewire.dashboard.charts.months-chart');
    }

}
