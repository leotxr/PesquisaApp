<?php

namespace App\Http\Livewire\Reports;

use App\Models\Fatura;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SectorReport extends Component
{
    public $start_date;
    public $end_date;
    public $faturas = [];

    public function mount()
    {


    }

    public function search()
    {
        $this->reset('faturas');
        $setores = Fatura::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->whereNotIn('setor', ['RM-COMPLEMENTO'])->groupBy('setor')->get('setor');
        $arr = [];
        foreach ($setores as $setor) {
            $arr[] = $setor->setor;
        }

        foreach ($arr as $a) {
            $count = Fatura::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->where('setor', $a)->count();
            $this->faturas[] = (object)['setor' => $a, 'total' => $count, 'x_clinic' => DB::connection('sqlsrv')->table('FATURA')
                ->whereBetween('DATA', [$this->start_date, $this->end_date])
                ->join('SETORES', 'SETORES.SETORID', '=', 'FATURA.SETORID')
                ->whereNotIn('SETORES.SETORID', [6,8,11,12,15,16,17,19])
                ->where('SETORES.DESCRICAO', '=', $a)
                ->count()];
        }


        $this->render();

    }

    public function render()
    {
        return view('livewire.reports.sector-report');
    }
}
