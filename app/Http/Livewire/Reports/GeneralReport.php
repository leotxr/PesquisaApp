<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Fatura;
use Illuminate\Support\Facades\DB;

class GeneralReport extends Component
{
    public $initial_date;
    public $final_date;
    public $query_total;


    public function getReport()
    {

    }

    private function getAgendamentos($role_id)
    {
        $agd = Rating::whereBetween('ratings.created_at', [$this->initial_date . ' 00:00:00', $this->final_date . ' 23:59:59'])
        ->join('employee_rating', 'employee_rating.rating_id', '=','ratings.id')
        ->join('employees','employee_rating.employee_id','=','employees.id')
        ->join('model_has_roles','model_has_roles.model_id','=','employees.id')
        ->whereNotNull('employee_rating.rate')
        ->where('model_has_roles.role_id', $role_id)
        ->where('employee_rating.role', 'agd')
        ->whereNotNull('atend_rate')
        ->get();

        return $agd;
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
