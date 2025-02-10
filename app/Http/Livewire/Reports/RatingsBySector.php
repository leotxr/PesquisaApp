<?php

namespace App\Http\Livewire\Reports;

use App\Models\Fatura;
use App\Traits\XClinicTraits;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RatingsBySector extends Component
{
    use XClinicTraits;
    public $ratings;
    public $setoresRadiologia;
    public $setoresRMTC;
    public $setoresUSG;
    public $start_date = '2024-02-02';
    public $end_date = '2024-02-02';
    public $faturas = [];

    public function mount()
    {
        /*
        $this->setoresRadiologia = ['DENSITOMETRIA', 'MAMOGRAFIA', 'RAIOSX', 'MAPA', 'ELETROCARDIOGRAMA', 'TC-ODONTOLOGICA', 'RX-ODONTOLOGICA'];
        $this->setoresRMTC = ['TOMOGRAFIA', 'RESSONANCIA'];
        $this->setoresUSG = ['ULTRA-SON', 'CARDIOLOGIA'];
        */


        $setores = Fatura::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->whereNotIn('setor', ['RM-COMPLEMENTO'])->groupBy('setor')->get('setor');
        $arr = [];
        foreach ($setores as $setor) {
            $arr[] = $setor->setor;
        }

        foreach ($arr as $a) {
            $faturas = Fatura::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->where('setor', $a)->get();
            $this->faturas[] = (object)['setor' => $a,
                'total' => $faturas];
        }


    }

    public function render()
    {
        return view('livewire.reports.ratings-by-sector');
    }
}
