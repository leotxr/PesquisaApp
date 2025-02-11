<?php

namespace App\Http\Livewire\Reports;

use App\Exports\SectorReportExport;
use App\Exports\SectorSatisfactionExport;
use App\Models\Fatura;
use App\Models\Rating;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\XClinicTraits;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

class SatisfactionByEmployee extends Component
{
    use XClinicTraits;
    public $start_date;
    public $end_date;
    public $faturas = [];

    public function mount() {}

    private function buscaFuncionarioRating($employeeId)
    {

        $results = DB::table('ratings as r')
            ->join('employee_rating as er', 'er.rating_id', '=', 'r.id')
            ->join('employees as e', 'e.id', '=', 'er.employee_id')
            ->whereBetween('r.data_req', [$this->start_date, $this->end_date])
            ->where('e.id', '=', $employeeId)
            ->select('er.rate as rate', 'r.id as id', 'e.name as name')
            ->get();

        return $results;
    }

    private function buscaFuncionarioFatura($employeeId)
    {
        $results = DB::table('faturas as r')
            ->join('employee_fatura as er', 'er.fatura_id', '=', 'r.id')
            ->join('employees as e', 'e.id', '=', 'er.employee_id')
            ->whereBetween('r.fatura_data', [$this->start_date, $this->end_date])
            ->where('e.id', '=', $employeeId)
            ->select('er.rate as rate', 'r.id as id', 'e.name as name')
            ->get();

        return $results;
    }
    public function search()
    {
        $this->reset('faturas');

        $er = DB::table('employees as e')
        ->join('employee_rating as er', 'er.employee_id', '=', 'e.id')
        ->whereNotNull('er.rate')
        ->select(DB::raw('DISTINCT er.employee_id'), 'e.name')
        ->get();
    
    
        foreach($er as $row)
        {
            $count = $this->buscaFuncionarioRating($row->employee_id);
            if($count->count() > 0)
            {
                $this->faturas[] = (object)[
                    'setor' => $row->name,
                    'total' => $count->count(),
                    'otimo' => $count->where('rate', '>', 3)->count(),
                    'regular' => $count->where('rate', '=', 3)->count(),
                    'ruim' => $count->where('rate', '<', 3)->count()
                ];
            }

        }

        $ef = DB::table('employees as e')
        ->join('employee_fatura as er', 'er.employee_id', '=', 'e.id')
        ->whereNotNull('er.rate')
        ->select(DB::raw('DISTINCT er.employee_id'), 'e.name')
        ->get();
    
        foreach($ef as $row)
        {
            $count = $this->buscaFuncionarioFatura($row->employee_id);
            if($count->count() > 0)
            {
                $this->faturas[] = (object)[
                    'setor' => $row->name,
                    'total' => $count->count(),
                    'otimo' => $count->where('rate', '>', 3)->count(),
                    'regular' => $count->where('rate', '=', 3)->count(),
                    'ruim' => $count->where('rate', '<', 3)->count()
                ];
            }

        }
        

        $this->render();
    }


    public function export()
    {
        $range = [
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ];
        $result = ['faturas' => $this->faturas];
        return Excel::download(new SectorSatisfactionExport($range, $result), 'satisfacao_por_funcionario' . $this->start_date . '-' . $this->end_date . '.xlsx');
    }


    public function render()
    {
        return view('livewire.reports.satisfaction-by-employee');
    }
}
