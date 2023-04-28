<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Fatura;

class DatePicker extends Component
{
    public $initial_date;
    public $final_date;

    public function search()
    {

    }

    public function render()
    {
        return view('livewire.dashboard.date-picker');
    }
}
