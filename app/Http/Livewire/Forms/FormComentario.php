<?php

namespace App\Http\Livewire\Forms;

use Livewire\Component;
use App\Models\Rating;

class FormComentario extends Component
{
    public $rating;
    public $comentario;
    public $rate;

    public function enviaComentario()
    {
        Rating::where('id', $this->rating->id)
            ->update([
                'comentario' => $this->comentario,
                'status_comentario_id' => 1
        ]);

            return redirect()->to('fim');
    }

    public function render()
    {
        return view('livewire.forms.form-comentario');
    }
}
