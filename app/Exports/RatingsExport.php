<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\Rating;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RatingsExport implements FromView
{
    use Exportable;

    public $start;
    public $end;
    public $status;
    public $selectedSector;
    public $sortField;
    public $sortDirection;

    public function __construct($range)
    {
        $this->start = $range['initial_date'];
        $this->end = $range['final_date'];
        $this->selectedSector = $range['selectedSector'];
        $this->sortField = $range['sortField'];
        $this->sortDirection = $range['sortDirection'];
    }

    public function view(): View
    {
        return view('admin.excel_tables.table-ratings', ['selectedSector'=> $this->selectedSector, 'data' => Rating::join('faturas', 'faturas.rating_id', '=', 'ratings.id')
        ->whereBetween('data_req', [$this->start, $this->end])
        ->whereIn('faturas.setor', $this->selectedSector)
        ->orderBy($this->sortField, $this->sortDirection)
        ->get()]);
    }
}
