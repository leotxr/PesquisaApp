<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\Rating;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CommentsExport implements FromView
{
    use Exportable;

    public $start;
    public $end;
    public $status;

    public function __construct($range)
    {
        $this->start = $range['initial_date'];
        $this->end = $range['final_date'];
        $this->status = $range['search_status'];
    }

    public function view(): View
    {
        return view('admin.tables.table-comment', ['ratings' => Rating::with('relFaturas')
            ->join('faturas', 'faturas.rating_id', '=', 'ratings.id')
            ->whereBetween('ratings.data_req', [$this->start, $this->end])
            ->whereNotNull('ratings.comentario')
            ->whereIn('status_comentario_id', $this->status)
            ->get()]);
    }
}
