<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Rating;

class DropDownButton extends Component
{
    public $label;

    public function mount($label)
    {
        $this->label = $label;
    }

    public function render()
    {
        return view('livewire.dashboard.drop-down-button');
    }
}
