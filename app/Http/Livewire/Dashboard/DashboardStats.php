<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class DashboardStats extends Component
{
    public $title;
    public $value;
    public $description;

    public function mount($title, $value, $description)
    {
        $this->title = $title;
        $this->value = $value;
        $this->description = $description;
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-stats');
    }
}
