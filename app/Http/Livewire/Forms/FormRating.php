<?php

namespace App\Http\Livewire\Forms;

use App\Models\EmployeeFatura;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Fatura;


class FormRating extends Component
{
    public $rating; //PESQUISA
    public $rate; // VALOR DA NOTA
    public $text;
    public $label; // NOME DO FUNCIONARIO (APENAS PARA MOSTRAR NO RENDER)
    public $field; // NOME DO CAMPO A SER ATUALIZADO
    public $hideForm;
    public $wire_function;
    public $fatura;
    public $showTextArea = false;
    public $comment;
    public $photo;


    public function mount($text, $label, $wire_function, $photo)
    {
        /*
        $this->text = "Como você avalia o atendimento realizado pela recepcionista";
        $this->label = $this->rating->recep_name;
        $this->wire_function = 'avaliaRecepcao';
        */

        $this->text = $text;
        $this->label = $label;
        $this->wire_function = $wire_function;
        $this->photo = $photo;
    }


    public function avaliaRecepcao()
    {
        Rating::where('id', $this->rating->id)
            ->update(['recep_rate' => $this->rate]);

        $rec = $this->rating->employees()->where('role', 'rec')->first();

        $rec->pivot->rate = $this->rate;
        $rec->pivot->save();

        $this->hideForm = true;

        /*
            $this->text = "Como você avalia o técnico";
            $this->label = $this->faturas;

            */
    }


    public function avaliaEnfermeira()
    {
        $this->fatura->enf_rate = $this->rate;
        $this->fatura->save();
        /*
                Fatura::where('id', $this->fatura->id)
                    ->update(['enf_rate' => $this->rate]);
        */
        $enf = $this->fatura->employees()->where('role', 'enf')->first();

        $enf->pivot->rate = $this->rate;
        $enf->pivot->save();

        $this->hideForm = true;
    }

    public function avaliaUSG()
    {
        $this->fatura->us_rate = $this->rate;
        $this->fatura->save();

        $enf = $this->fatura->employees()->where('role', 'usg')->first();

        $enf->pivot->rate = $this->rate;
        $enf->pivot->save();

        $this->hideForm = true;
    }


    public function avaliaEmpresa()
    {
        Rating::where('id', $this->rating->id)
            ->update([
                'nota_clinica' => $this->rate,
                'finalizado' => 1
            ]);

        $this->hideForm = true;
        $this->showTextArea = true;
    }


    public function render()
    {
        return view("livewire.forms.form-rating");
    }
}
