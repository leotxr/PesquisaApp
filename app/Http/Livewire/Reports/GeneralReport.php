<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Fatura;
use Illuminate\Support\Facades\DB;
use App\Traits\XClinicTraits;

class GeneralReport extends Component
{
    use XClinicTraits
    public $initial_date;
    public $final_date;
    public $query_total;


    public function getReport()
    {

    }


    public function render()
    {
        return view('livewire.reports.general-report', [
            'total' => Rating::where('finalizado', 1)->whereBetween('data_req', [$this->initial_date, $this->final_date])->get(),
            'recep' => Rating::where('finalizado', 1)->whereNotNull('recep_rate')->whereBetween('data_req', [$this->initial_date, $this->final_date])->get(),
            'recep_agd' => $this->getAgendamentos(1),
            'tel' => $this->getAgendamentos(7),
            'wpp' => $this->getAgendamentos(8),
            'usg' => Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->whereNotNull('us_rate')
            ->whereBetween('data_req', [$this->initial_date, $this->final_date])
            ->get(),
            'enf' => Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->whereNotNull('enf_rate')
            ->whereBetween('data_req', [$this->initial_date, $this->final_date])
            ->get(),
            'tec' => Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->whereNotNull('faturas.livro_rate')
            ->whereNotNull('faturas.tec_name')
            ->whereBetween('ratings.data_req', [$this->initial_date, $this->final_date])
            ->get(),
            'med' => Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->whereIn('faturas.setor', ['ULTRA-SON', 'CARDIOLOGIA', 'ANGIOLOGIA'])
            ->whereNotNull('faturas.livro_rate')
            ->whereBetween('ratings.data_req', [$this->initial_date, $this->final_date])
            ->get(),
        ]);
    }
}
