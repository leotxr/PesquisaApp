<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Fatura;
use App\Models\Rating;
use App\Traits\XClinicTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class GetDadosClienteController extends Controller
{
    use XClinicTraits;

    public $paciente_id;

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $this->paciente_id = $request->pacienteid;

        $request->validate([
            'pacienteid' => 'required|max:8',
        ]);

        #RETORNA UM ARRAY COM TODAS AS FATURAS(EXAMES) JUNTO AS REQUISICOES
        $requisicoes = $this->getRequests($this->paciente_id);



        if (!$requisicoes) {
            $notification = array(
                'message' => 'Código não encontrado! Verifique seu protocolo e tente novamente.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }


        $statuses = Arr::pluck($requisicoes, 'STATUSID');

        if (in_array("0", $statuses)) {
            $notification = array(
                'message' => 'Realize todos os exames antes de avaliar os atendimentos!',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }

        #ARMAZENA A PRIMEIRA REQUISICAO DA LISTA, POIS UMA REQUISICAO TEM VARIOS EXAMES
        $rating = Rating::updateOrCreate([
            'pac_name' => $requisicoes[0]->PACIENTE ?? NULL,
            'pac_id' => $requisicoes[0]->PACIENTEID ?? NULL,
            'data_req' => $requisicoes[0]->DATA ?? NULL,
            'recep_name' => $requisicoes[0]->RECEPCIONISTA ?? NULL,
            'requisicao_id' => $requisicoes[0]->REQUISICAO ?? NULL
        ]);

        if ($rating) {
            $rec = Employee::where('x_clinic_id', $requisicoes[0]->RECEP_ID)->first();
            $rating->employees()->sync([$rec->id => ['role' => 'rec']]);
        }


        #CARREGA AS RECEPCIONISTAS DO USG
        //$usg = $this->getUSG($rating->requisicao_id);

        $i = 0;

        #PERCORRE O VETOR DE REQUISICOES PARA SALVAR CADA EXAME SEPARADAMENTE
        foreach ($requisicoes as $requisicao) {
            if ($requisicao->SETOR == "RESSONANCIA" || $requisicao->SETOR == "TOMOGRAFIA") {
                #CARREGA AS ENFERMEIRAS NA REQUISICAO
                $rasocorrencias = $this->getNurses($requisicao->REQUISICAO, $requisicao->FATURA);

                //dd($rasocorrencias);

                if ($rasocorrencias) {
                    $fat = Fatura::updateOrCreate([
                        'rating_id' => $rating->id,
                        'requisicao_id' => $requisicao->REQUISICAO ?? NULL,
                        'fatura_data' => $rating->data_req ?? NULL,
                        'livro_name' => $requisicao->MEDICO ?? NULL,
                        'tec_name' => $requisicao->TECNICO ?? NULL,
                        'enf_name' => $rasocorrencias[0]->ENFERMEIRA ?? NULL,
                        'setor' => $requisicao->SETOR ?? NULL
                    ]);

                    $enf = Employee::where('x_clinic_id', $rasocorrencias[0]->ENF_ID)->first();
                    $tec = Employee::where('x_clinic_id', $requisicao->MED_ID)->first();


                    if ($fat->employees) {
                        $fat->employees()->detach([$tec->id]);
                        $fat->employees()->detach([$enf->id]);
                    }
                    $fat->employees()->attach([$tec->id => ['role' => 'tec']]);
                    $fat->employees()->attach([$enf->id => ['role' => 'enf']]);

                    //dd($fat->employees()->get());

                }

            } elseif ($requisicao->SETOR == "ULTRA-SON" || $requisicao->SETOR == "CARDIOLOGIA" || $requisicao->SETOR == "ANGIOLOGIA") {
                $usg = $this->getUSG($requisicao->REQUISICAO, $requisicao->FATURA);

                //dd($usg->USG_ID);
                $fat = Fatura::updateOrCreate([
                    'rating_id' => $rating->id,
                    'requisicao_id' => $requisicao->REQUISICAO ?? NULL,
                    'fatura_data' => $rating->data_req ?? NULL,
                    'livro_name' => $requisicao->MEDICO ?? NULL,
                    'tec_name' => $requisicao->TECNICO ?? NULL,
                    'us_name' => $usg->USUARIO ?? NULL,
                    'setor' => $requisicao->SETOR ?? NULL
                ]);

                $recep_usg = Employee::where('x_clinic_id', $usg->USG_ID)->first();


                if ($recep_usg)
                    $fat->employees()->sync([$recep_usg->id => ['role' => 'usg']]);

                $i++;
            } else {
                $fat = Fatura::updateOrCreate([
                    'rating_id' => $rating->id,
                    'requisicao_id' => $rating->requisicao_id ?? NULL,
                    'fatura_data' => $rating->data_req ?? NULL,
                    'livro_name' => $requisicao->MEDICO ?? NULL,
                    'tec_name' => $requisicao->TECNICO ?? NULL,
                    'setor' => $requisicao->SETOR ?? NULL
                ]);
                $tec = Employee::where('x_clinic_id', $requisicao->MED_ID)->first();

                if ($tec)
                    $fat->employees()->sync([$tec->id => ['role' => 'tec']]);
            }
        }


        $fatura = Fatura::where('rating_id', $rating->id)->get();


        if ($requisicoes)
            return view('rating', compact('rating', 'fatura'));
        else {
            $notification = array(
                'message' => 'Código não encontrado! Verifique seu protocolo e tente novamente.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);

        }
    }
}
