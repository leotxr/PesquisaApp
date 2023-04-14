<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rating;
use App\Models\Fatura;
use App\Http\Controllers\RatingController;

class GetDadosClienteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = date('Y/m/d');
        #$datainicio = date('Y/m/d', strtotime('-7 days'));
        $paciente_id = $request->pacienteid;

        $request->validate([
            'pacienteid' => 'required',
        ]);

        #RETORNA UM ARRAY COM TODAS AS FATURAS(EXAMES) JUNTO AS REQUISICOES
        $requisicoes = DB::connection('sqlsrv')->table('WORK_LIST')
            ->leftJoin('FATURA', function ($join_fatura) {
                $join_fatura->on('FATURA.FATURAID', '=', 'WORK_LIST.FATURAID')
                    ->on('FATURA.UNIDADEID', '=', 'WORK_LIST.UNIDADEID')
                    ->on('FATURA.PACIENTEID', '=', 'WORK_LIST.PACIENTEID');
            })
            ->leftJoin('PACIENTE', function ($join_paciente) {
                $join_paciente->on('PACIENTE.PACIENTEID', '=', 'WORK_LIST.PACIENTEID')
                    ->on('PACIENTE.UNIDADEID', '=', 'FATURA.UNIDADEPACIENTEID');
            })
            ->leftJoin('PROCEDIMENTOS', 'PROCEDIMENTOS.PROCID', '=', 'FATURA.PROCID')
            ->leftJoin('SETORES', 'SETORES.SETORID', '=', 'FATURA.SETORID')
            ->leftJoin('MEDICOS', 'MEDICOS.MEDICOID', '=', 'FATURA.TECNICOID')
            ->leftJoin('WORK_FILAS', 'WORK_FILAS.FILAID', '=', 'WORK_LIST.FILAID')
            ->leftJoin('USUARIOS', 'USUARIOS.USERID', '=', 'FATURA.USUARIO')
            ->where('WORK_LIST.PACIENTEID', '=', $paciente_id)
            ->whereDate('FATURA.DATA', '=',  date('Y/m/d'))
            ->select(DB::raw("DISTINCT FORMAT(FATURA.DATA, 'yyyy/MM/dd') AS DATA, WORK_LIST.REQUISICAOID AS REQUISICAO, FATURA.PACIENTEID AS PACIENTEID, PACIENTE.NOME AS PACIENTE, PROCEDIMENTOS.DESCRICAO AS PROCEDIMENTO, SETORES.DESCRICAO AS SETOR, MEDICOS.NOME_SOCIAL AS TECNICO, WORK_FILAS.FILANOME AS MEDICO, USUARIOS.NOME_SOCIAL AS RECEPCIONISTA, FATURA.REQUISICAOID"))
            ->get()->toArray();



            #ARMAZENA A PRIMEIRA REQUISICAO DA LISTA, POIS UMA REQUISICAO TEM VARIOS EXAMES
        $rating = Rating::updateOrCreate([
            'pac_name' => $requisicoes[0]->PACIENTE ?? NULL,
            'pac_id' => $requisicoes[0]->PACIENTEID ?? NULL,
            'data_req' => $requisicoes[0]->DATA ?? NULL,
            'recep_name' => $requisicoes[0]->RECEPCIONISTA ?? NULL,
            'requisicao_id' => $requisicoes[0]->REQUISICAO ?? NULL
        ]);


        #CARREGA AS ENFERMEIRAS NA REQUISICAO
        $rasocorrencias = DB::connection('sqlsrv')->table('RASOCORRENCIAS')
        ->join('WORK_LIST', function ($join_paciente) {
            $join_paciente->on('WORK_LIST.PACIENTEID', '=', 'RASOCORRENCIAS.PACIENTEID')
                ->on('WORK_LIST.DATA', '=', 'RASOCORRENCIAS.DATA');
        })
        ->join('USUARIOS', 'USUARIOS.USERID', '=', 'RASOCORRENCIAS.USERID')
        ->where('RASOCORRENCIAS.OBSERVACAO', '=', 'OBSERVAÇÃO')
        ->where('WORK_LIST.REQUISICAOID', '=', $rating->requisicao_id)
        ->select(DB::raw("TOP 1 USUARIOS.NOME_SOCIAL AS ENFERMEIRA"))
        ->get()->toArray();

        #CARREGA AS RECEPCIONISTAS DO USG
        $sqlsrv2 = "Select DISTINCT O.DATA AS DATA, F.REQUISICAOID, SE.DESCRICAO, USU.NOME_SOCIAL AS USUARIO ";
        $sqlsrv2 = $sqlsrv2 . "FROM RASOCORRENCIAS O ";
        $sqlsrv2 = $sqlsrv2 . "LEFT OUTER JOIN FATURA F ON O.PACIENTEID=F.PACIENTEID AND O.UNIDADEID=F.UNIDADEID AND O.FATURAID=F.FATURAID ";
        $sqlsrv2 = $sqlsrv2 . "LEFT OUTER JOIN USUARIOS USU ON (O.USERID = USU.USERID) ";
        $sqlsrv2 = $sqlsrv2 . "LEFT OUTER JOIN SETORES SE ON (SE.SETORID = F.SETORID) ";
        $sqlsrv2 = $sqlsrv2 . "WHERE O.RASEVENTOID IN (38) AND SE.DESCRICAO IN ('ULTRA-SON', 'CARDIOLOGIA') AND F.REQUISICAOID = '$rating->requisicao_id' ";
        $usg = DB::connection('sqlsrv')->select($sqlsrv2);


        #PERCORRE O VETOR DE REQUISICOES PARA SALVAR CADA EXAME SEPARADAMENTE
        foreach ($requisicoes as $requisicao) {
            if($requisicao->SETOR == "RESSONANCIA")
            {
            Fatura::updateOrCreate([
                'rating_id' => $rating->id,
                'requisicao_id' => $rating->requisicao_id ?? NULL,
                'fatura_data' => $rating->data_req ?? NULL,
                'livro_name' => $requisicao->MEDICO ?? NULL,
                'tec_name' => $requisicao->TECNICO ?? NULL,
                'enf_name' => $rasocorrencias[0]->ENFERMEIRA ?? NULL,
                'setor' => $requisicao->SETOR ?? NULL
            ]);
            }elseif($requisicao->SETOR == "ULTRA-SON"){
                Fatura::updateOrCreate([
                    'rating_id' => $rating->id,
                    'requisicao_id' => $rating->requisicao_id ?? NULL,
                    'fatura_data' => $rating->data_req ?? NULL,
                    'livro_name' => $requisicao->MEDICO ?? NULL,
                    'tec_name' => $requisicao->TECNICO ?? NULL,
                    'us_name' => $usg[0]->USUARIO ?? NULL,
                    'setor' => $requisicao->SETOR ?? NULL
                ]);
            }else
            {
                Fatura::updateOrCreate([
                    'rating_id' => $rating->id,
                    'requisicao_id' => $rating->requisicao_id ?? NULL,
                    'fatura_data' => $rating->data_req ?? NULL,
                    'livro_name' => $requisicao->MEDICO ?? NULL,
                    'tec_name' => $requisicao->TECNICO ?? NULL,
                    'setor' => $requisicao->SETOR ?? NULL
                ]);
            }
        }


        $fatura = Fatura::where('rating_id', $rating->id)->get();



        if ($requisicoes)
            return view('rating', compact('rating', 'fatura'));
        else
            return redirect()->back()->withErrors('Código não encontrado! Verifique seu protocolo e tente novamente.');
    }
}
