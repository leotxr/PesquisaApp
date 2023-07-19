<?php

namespace App\Http\Livewire\Reports;
use Illuminate\Support\Collection;
use App\Models\Rating;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RatingsExport;

class SectorsReport extends Component
{
    use WithPagination;

    public $sortField = 'ratings.data_req';
    public $sortDirection = 'desc';
    public $search = '';
    public $setoresUSG = [];
    public $setoresRadiologia = [];
    public $setoresRMTC = [];
    public $selectedSector = [];
    public $modalFilters = false;
    public $initial_date;
    public $final_date;


    public function mount()
    {
        
        $this->setoresRadiologia = ['DENSITOMETRIA', 'MAMOGRAFIA', 'RAIOSX', 'MAPA', 'ELETROCARDIOGRAMA', 'TC-ODONTOLOGICA', 'RX-ODONTOLOGICA'];
        $this->setoresRMTC = ['TOMOGRAFIA', 'RESSONANCIA'];
        $this->setoresUSG = ['ULTRA-SON', 'CARDIOLOGIA'];

        //$this->selectedSector = array_merge($this->setoresRadiologia, $this->setoresRMTC, $this->setoresUSG );


    }


    public function searchFilters()
    {
        $this->modalFilters = true;
    }

    public function sortBy($field)
    {

        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'desc' ? 'asc' : 'desc'
            : 'desc';

        $this->sortField = $field;
    }

    public function export() 
    {
        $range = ['initial_date'=>$this->initial_date, 
        'final_date'=>$this->final_date, 
        'selectedSector'=>$this->selectedSector,
        'sortField'=>$this->sortField,
        'sortDirection' => $this->sortDirection];
        return Excel::download(new RatingsExport($range), 'avaliacoes.xlsx');
    }

    public function render()
    {
        return view('livewire.reports.sectors-report', 
        ['data' => Rating::join('faturas', 'faturas.rating_id', '=', 'ratings.id')
        ->whereBetween('data_req', [$this->initial_date, $this->final_date])
        ->whereIn('faturas.setor', $this->selectedSector)
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10)] );
    }
}
