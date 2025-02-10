<?php

namespace App\Http\Livewire\Reports;

use App\Exports\RatingsExport;
use App\Exports\SectorReportExport;
use App\Models\Employee;
use App\Models\Fatura;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class SectorReport extends Component
{
    public $start_date;
    public $end_date;
    public $faturas = [];
    public $ratings = [];
    public $agendamentos = [];

    public function mount()
    {

        //dd(DB::connection('sqlsrv')->table('FATURA')
        //    ->whereBetween('DATA', ['2024-02-01', '2024-02-01'])
        //    ->join('SETORES', 'SETORES.SETORID', '=', 'FATURA.SETORID')
        //    ->whereNotIn('SETORES.SETORID', [6, 8, 11, 12, 15, 16, 17, 19])
        //    ->where('SETORES.DESCRICAO', '=', 'RAIOSX')
        //    ->select(DB::raw('COUNT(DISTINCT (FATURA.REQUISICAOID)) AS TOTAL'))->first());

        //dd($this->getRatings('2024-02-01', '2024-02-05'));

    }

    public function getFaturas($start_date, $end_date, $sector)
    {
        return DB::connection('sqlsrv')->table('FATURA')
            ->whereBetween('DATA', [$start_date, $end_date])
            ->join('SETORES', 'SETORES.SETORID', '=', 'FATURA.SETORID')
            ->whereNotIn('SETORES.SETORID', [6, 8, 11, 12, 15, 16, 17, 19])
            ->where('SETORES.DESCRICAO', '=', $sector)
            ->select(DB::raw('COUNT(DISTINCT (FATURA.REQUISICAOID)) AS TOTAL'))->first();
    }

    public function getRatings($start_date, $end_date)
    {
        return DB::connection('sqlsrv')->table('TOTEM_FILAS_ESPERA')
            ->join('USUARIOS', 'USUARIOS.USERID', '=', 'TOTEM_FILAS_ESPERA.CHAMADO')
            ->join('TOTEM_CONFIGURACOES', 'TOTEM_CONFIGURACOES.TOTEMID', '=', 'TOTEM_FILAS_ESPERA.TOTEMID')
            ->leftJoin('PACIENTE', 'PACIENTE.PACIENTEID', '=', 'TOTEM_FILAS_ESPERA.PACIENTEID')
            ->whereBetween('TOTEM_FILAS_ESPERA.DATA', [$start_date, $end_date])
            ->whereNotNull('TOTEM_FILAS_ESPERA.CHAMADO')
            ->whereNotNull('PACIENTE.NOME')
            ->select(DB::raw('COUNT(DISTINCT CONCAT(TOTEM_FILAS_ESPERA.DATA, TOTEM_FILAS_ESPERA.PACIENTEID, PACIENTE.NOME, USUARIOS.NOME_SOCIAL)) AS TOTAL'))->first();
    }

    private function getAgendamentos($role_id)
    {
        $agd = Rating::whereBetween('ratings.created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->join('employee_rating', 'employee_rating.rating_id', '=','ratings.id')
        ->join('employees','employee_rating.employee_id','=','employees.id')
        ->join('model_has_roles','model_has_roles.model_id','=','employees.id')
        ->whereNotNull('employee_rating.rate')
        ->where('model_has_roles', $role_id)
        ->where('employee_rating.role', 'agd')
        ->count();

        return $agd;
    }

    public function search()
    {
        $this->reset('faturas', 'ratings', 'agendamentos');


        //$recepcionistas = Employee::whereHas("roles", function($q){ $q->where("name", "recepcionista"); })->get();
        $setores = Fatura::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->whereNotIn('setor', ['RM-COMPLEMENTO', 'MM-COMPLEMENTO', 'TC-COMPLEMENTO'])->groupBy('setor')->get('setor');
        $arr = [];
        foreach ($setores as $setor) {
            $arr[] = $setor->setor;
        }

        foreach ($arr as $a) {
            $count = Fatura::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->where('setor', $a)->count();
            $this->faturas[] = (object)['setor' => $a, 'total' => $count, 'x_clinic' => $this->getFaturas($this->start_date, $this->end_date, $a)->TOTAL];
        }

        $this->faturas[] = (object)['setor' => 'RECEPCAO', 'total' => Rating::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->whereNotNull('recep_rate')->count(), 'x_clinic' => $this->getRatings($this->start_date, $this->end_date)->TOTAL];
        $this->faturas[] = (object)['setor' => 'AGENDAMENTO RECEPÇÃO', 'total' => $this->getAgendamentos(1), 'x_clinic' => $this->getRatings($this->start_date, $this->end_date)->TOTAL];
        $this->faturas[] = (object)['setor' => 'AGENDAMENTO TELEFONE/WHATSAPP', 'total' => Rating::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->whereNotNull('atend_rate')->count(), 'x_clinic' => $this->getRatings($this->start_date, $this->end_date)->TOTAL];

        //dd($this->faturas);

        $this->render();

    }

    public function export()
    {
        $range = ['start_date' => $this->start_date,
            'end_date' => $this->end_date];
        $result = ['faturas' => $this->faturas];
        return Excel::download(new SectorReportExport($range, $result), 'avaliacoes_por_setor_' . $this->start_date . '-' . $this->end_date . '.xlsx');
    }

    public function render()
    {
        return view('livewire.reports.sector-report');
    }
}
