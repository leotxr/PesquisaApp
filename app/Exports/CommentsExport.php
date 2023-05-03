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

    public function view(): View
    {
        return view('admin.tables.table-comment', ['ratings' =>  Rating::with('relFaturas')
            ->join('faturas', 'faturas.rating_id', '=', 'ratings.id')
            ->whereBetween('ratings.data_req', ['2023-04-01', '2023-04-30'])
            ->whereNotNull('ratings.comentario')->get()]);
    }
}
