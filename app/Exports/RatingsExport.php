<?php

namespace App\Exports;

use App\Models\Rating;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RatingsExport implements FromView
{

    public function view(): View
    {
        return view('livewire.dashboard.search-comments', ['comments' => Rating::all()]);
    }

}
