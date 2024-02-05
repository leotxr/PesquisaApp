<?php

namespace App\Http\Livewire\Reports;

use App\Exports\SectorReportExport;
use App\Exports\SectorSatisfactionExport;
use App\Models\Fatura;
use App\Models\Rating;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class SatisfactionBySector extends Component
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
            $count_faturas = Fatura::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->where('setor', $a)->get();
            $this->faturas[] = (object)['setor' => $a, 'total' => $count_faturas->count(),
                'otimo' => $count_faturas->where('livro_rate', '>', 3)->count(),
                'regular' => $count_faturas->where('livro_rate', '=', 3)->count(),
                'ruim' => $count_faturas->where('livro_rate', '<', 3)->count()];
        }

        $count_recep = Rating::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->whereNotNull('recep_rate')->get();
        $this->faturas[] = (object)['setor' => 'RECEPCAO',
            'total' => $count_recep->count(),
            'otimo' => $count_recep->where('recep_rate', '>', 3)->count(),
            'regular' => $count_recep->where('recep_rate', '=', 3)->count(),
            'ruim' => $count_recep->where('recep_rate', '<', 3)->count()];

        $this->render();
    }


        public function export()
    {
        $range = ['start_date' => $this->start_date,
            'end_date' => $this->end_date];
        $result = ['faturas' => $this->faturas];
        return Excel::download(new SectorSatisfactionExport($range, $result), 'satisfacao_por_setor' . $this->start_date . '-' . $this->end_date . '.xlsx');
    }


    public function render()
    {
        return view('livewire.reports.satisfaction-by-sector');
    }
}
