<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Rating;

class DashboardStats extends Component
{
    public $initial_date;
    public $final_date;
    public $description;


    public function render()
    {
        return view('livewire.dashboard.dashboard-stats', [
            'today' => Rating::where('data_req', date('Y/m/d'))->count(),
        'month' => Rating::whereMonth('data_req', date('m'))->whereYear('data_req', date('Y'))->count()]);
    }
}
