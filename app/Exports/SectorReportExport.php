<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\Rating;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SectorReportExport implements FromView
{
    use Exportable;

    public $start_date;
    public $end_date;
    public $faturas;


    public function __construct($range, $faturas)
    {

        $this->start_date = $range['start_date'];
        $this->end_date = $range['end_date'];
        $this->faturas = $faturas;

    }

    public function view(): View
    {
        return view('admin.tables.table-setores', ['faturas' => $this->faturas['faturas']]);
    }
}
