<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Rating;

class DropDownButton extends Component
{
    public $comment;

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function setPositivo()
    {
        
        $this->comment = Rating::find($this->comment->id);
        $this->comment->status_comentario_id = 1;
        if($this->comment->save())
        session()->flash('message', 'Comentário marcado como Positivo!');
        

    }

    public function setNegativo()
    {

        $this->comment = Rating::find($this->comment->id);
        $this->comment->status_comentario_id = 2;
        $this->comment->save();
        
    }

    public function setSugestao()
    {

        $this->comment = Rating::find($this->comment->id);
        $this->comment->status_comentario_id = 3;    
        $this->comment->save();

        
    }
    public function render()
    {
        return view('livewire.dashboard.drop-down-button');
    }
}
