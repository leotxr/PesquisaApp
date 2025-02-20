<?php

namespace App\Http\Livewire\Dashboard\Charts;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Fatura;
use Illuminate\Support\Facades\DB;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use App\Traits\XClinicTraits;


class AtendimentoChart extends Component
{
    use XClinicTraits;

    public $sectors = [];
    public $sector_count = [];
    public $start_date;
    public $end_date;
    public $faturas = [];
    public $setores = [];

    public function mount()
    {

        $this->getSectorsMonth();
    }
    public function getSectorsMonth(): void
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');

        $count_recep = Rating::whereBetween('data_req', [$this->start_date, $this->end_date])->where('finalizado', '=', 1)->get();
        $this->setores[] = 'RECEPÇÃO';
        $this->faturas[] = $count_recep->count();

        $agd_recep = $this->getAgendamentosPesquisa(1, $this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59');
        $this->setores[] = 'REC. AGENDAMENTO';
        $this->faturas[] = $agd_recep->count();

        $tel = $this->getAgendamentosPesquisa(7, $this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59');
        $this->setores[] = 'TELEFONIA';
        $this->faturas[] = $tel->count();

        $wpp = $this->getAgendamentosPesquisa(8, $this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59');
        $this->setores[] = 'WHATSAPP';
        $this->faturas[] = $wpp->count();
    }

    public function render()
    {
        return view('livewire.dashboard.charts.atendimento-chart');
    }
}
