<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Status;

class TableComment extends Component
{
    public $comment;
    public $statuses;
    public $status;

    public function edit_status()
    {
        dd($this->comment);
        $this->comment = Rating::find($this->comment->id);

        $this->comment->status_comentario_id = $this->status->id;

        $this->comment->save();

    }
    
    public function render()
    {
        return view('livewire.dashboard.table-comment');
    }
}
