<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;

class RatingsBySector extends Component
{
    public $ratings;
    public $setoresRadiologia;
    public $setoresRMTC;
    public $setoresUSG;

    public function mount()
    {
        $this->setoresRadiologia = ['DENSITOMETRIA', 'MAMOGRAFIA', 'RAIOSX', 'MAPA', 'ELETROCARDIOGRAMA', 'TC-ODONTOLOGICA', 'RX-ODONTOLOGICA'];
        $this->setoresRMTC = ['TOMOGRAFIA', 'RESSONANCIA'];
        $this->setoresUSG = ['ULTRA-SON', 'CARDIOLOGIA'];
    }

    public function render()
    {
        return view('livewire.reports.ratings-by-sector');
    }
}
