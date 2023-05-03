<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Rating;

class SelectStatus extends Component
{
    public $value;
    public $comment;
    public $fill_color;
    public $status_icon;
    public $status;


    public function mount($comment, $status)
    {
        $this->comment = Rating::find($comment);

        
        $this->fill_color = $status->color;


        $this->status = $status;
    }

    public function edit_status()
    {
        
        $comentario = $this->comment;
        $comentario->status_comentario_id = $this->status->id;
        $comentario->save();

    }
    
    public function render()
    {

        return view('livewire.dashboard.select-status');
    }
}
