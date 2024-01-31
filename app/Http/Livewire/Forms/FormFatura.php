<?php

namespace App\Http\Livewire\Forms;

use Livewire\Component;
use App\Models\Fatura;
use App\Models\Rating;

class FormFatura extends Component
{
    public $fatura;
    public $rating; //PESQUISA
    public $rate; // VALOR DA NOTA
    public $text;
    public $label; // NOME DO FUNCIONARIO (APENAS PARA MOSTRAR NO RENDER)
    public $field; // NOME DO CAMPO A SER ATUALIZADO
    public $hideFatura;
    public $wire_function;


    public function mount($fatura)
    {
        $this->text = "Como você avalia o exame ralizado pelo(a) técnico(a)";
        $this->fatura = $fatura;
    }


    public function avaliaRadiologia()
    {
        Fatura::where('id', $this->fatura->id)
        ->update(['livro_rate' => $this->rate]);

        if($this->fatura->tec_name != NULL)
        {
            $tec = $this->fatura->employees()->where('role', 'tec')->first();

            $tec->pivot->rate = $this->rate;
            $tec->pivot->save();
        }


        $this->hideFatura = true;
    }




    public function render()
    {
        return view('livewire.forms.form-fatura');
    }
}
