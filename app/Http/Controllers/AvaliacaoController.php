<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Avaliacao;
use Symfony\Component\Finder\Finder;

class AvaliacaoController extends Controller
{
    /*
    public function getDados(Request $request)
    {
        $dataForm = $request->all();
        $requisicao_id = $dataForm['requisicao_id'];
        $sqlsrv = "Select TOP 1 PA.NOME, PA.PACIENTEID, FORMAT(FA.DATA, 'yyyy/MM/dd') AS DATA, PR.DESCRICAO from FATURA AS FA ";
        $sqlsrv = $sqlsrv . "INNER JOIN PACIENTE AS PA ON PA.PACIENTEID = FA.PACIENTEID ";
        $sqlsrv = $sqlsrv . "INNER JOIN PROCEDIMENTOS AS PR ON PR.PROCID = FA.PROCID ";
        $sqlsrv = $sqlsrv . "WHERE FA.REQUISICAOID = '$requisicao_id' ";
        $requisicoes = DB::connection('sqlsrv')->select($sqlsrv);
        return view('avaliar', ['requisicoes' => $requisicoes]);
    }
    */

    public function __construct()
    {
        $this->objAvaliacao = new Avaliacao();
    }

    public function create()
    {

        return view('welcome');
    }
    public function store(Request $request)
    {
        $cad = DB::table('ratings')->insert([
            'data_req' => $request->data_req,
            'paciente_id' => $request->paciente_id,
            'paciente_name' => $request->paciente_name,
            'atendente_name' => $request->atendente_name,
            'recepcionista_name' => $request->recepcionista_name,
            'tecnico_name' => $request->tecnico_name,
            'medico_name' => $request->medico_name,
            #'procedimento' => $request->procedimento,
            #'setor' => $request->setor,
            'nota_agenda' => $request->rating1,
            'nota_recepcao' => $request->rating2,
            'nota_tecnico' => $request->rating3,
            'nota_clinica' => $request->rating4,
            'nota_medico' => $request->rating5,
        ]);

        if ($cad) {
            $dataForm = $request->all();
            $data_req = $dataForm['data_req'];
            $paciente_id = $dataForm['paciente_id'];
            $sqlsrv = "Select TOP 1 A.PACIENTEID, FORMAT(A.DATA, 'yyyy/MM/dd') AS DATA, A.NOMEPAC AS PACIENTE, A.USERNAME AS ATENDENTE, A.USUARIO, A.NOME_EXAME AS PROCEDIMENTO FROM VW_AGENDA AS A ";
            $sqlsrv = $sqlsrv . "WHERE A.DATA = '$data_req' AND ";
            $sqlsrv = $sqlsrv . "A.PACIENTEID = '$paciente_id' AND ";
            $sqlsrv = $sqlsrv . "A.USERNAME IS NOT NULL";
            $agendas = DB::connection('sqlsrv')->select($sqlsrv);
            return view('agenda-data', ['agendas' => $agendas]);
        }
    }

    public function edit(Avaliacao $id)
    {
        $avaliacao = Avaliacao::find($id);

        return view('avaliar', compact('avaliacao'));
    }

    public function editAgenda(Avaliacao $id)
    {
        $avaliacao = Avaliacao::find($id);

        return view('agenda-data', compact('agendas'));
    }



    public function update(Request $request)
    {
        $dataForm = $request->all();
        $data_req = $dataForm['data_req'];
        $paciente_id = $dataForm['paciente_id'];
        $atendente_name = $dataForm['atendente_name'];
        $nota_agenda = $_GET['rating1'];
        $mysql = "Update avaliacaos ";
        $mysql = $mysql . "SET atendente_name = '$atendente_name', ";
        $mysql = $mysql . "nota_agenda = '$nota_agenda' ";
        $mysql = $mysql . "WHERE data_req = '$data_req' AND paciente_id = '$paciente_id' ";
        $agendas = DB::connection('mysql')->update($mysql);

        if ($agendas) {

            $sqlsrv = "Select FORMAT(FAT.DATA, 'yyyy/MM/dd'), WL.REQUISICAOID AS REQUISICAO, FAT.PACIENTEID, PAC.NOME AS PACIENTE, PR.DESCRICAO AS PROCEDIMENTO, SE.DESCRICAO AS SETOR, TEC.NOME AS TECNICO, WF.FILANOME AS MEDICO, US.NOME_SOCIAL AS RECEPCIONISTA, FAT.REQUISICAOID from WORK_LIST AS WL ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN FATURA FAT ON FAT.FATURAID = WL.FATURAID AND FAT.UNIDADEID = WL.UNIDADEID AND FAT.PACIENTEID = WL.PACIENTEID ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN PACIENTE PAC ON PAC.PACIENTEID = WL.PACIENTEID AND PAC.UNIDADEID = FAT.UNIDADEPACIENTEID ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN PROCEDIMENTOS PR ON PR.PROCID = FAT.PROCID ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN SETORES SE ON SE.SETORID = FAT.SETORID ";
            $sqlsrv = $sqlsrv . "LEFT JOIN MEDICOS TEC ON TEC.MEDICOID = FAT.TECNICOID ";
            $sqlsrv = $sqlsrv . "LEFT JOIN WORK_FILAS WF ON WF.FILAID = WL.FILAID ";
            $sqlsrv = $sqlsrv . "LEFT JOIN USUARIOS US ON US.USERID = FAT.USUARIO ";
            $sqlsrv = $sqlsrv . "WHERE FAT.DATA = '$data_req' AND FAT.PACIENTEID = '$paciente_id'";
            $requisicoes = DB::connection('sqlsrv')->select($sqlsrv);
            return view('avaliar', ['requisicoes' => $requisicoes]);
        }
        else
        {
            echo '$php_errormsg';
        }
    }

    public function storeAgenda(Request $request, $id)
    {
        $edit = Avaliacao::where(['id' => $id])->update([
            'atendente_name' => $request->atendente_name,
            #'setor' => $request->setor,
            'nota_agenda' => $request->rating1,

        ]);


        if ($edit)
            return redirect()->back();
    }

    public function getDados(Request $request)
    {
        $dataForm = $request->all();
        $requisicao_id = $dataForm['requisicao_id'];
        $sqlsrv = "Select FORMAT(FAT.DATA, 'yyyy/MM/dd') AS DATA, FAT.PACIENTEID AS PACIENTEID, PAC.NOME AS PACIENTE, PR.DESCRICAO AS PROCEDIMENTO, SE.DESCRICAO AS SETOR, TEC.NOME AS TECNICO, WF.FILANOME AS MEDICO, US.NOME_SOCIAL AS RECEPCIONISTA, FAT.REQUISICAOID from WORK_LIST AS WL ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN FATURA FAT ON FAT.FATURAID = WL.FATURAID AND FAT.UNIDADEID = WL.UNIDADEID AND FAT.PACIENTEID = WL.PACIENTEID ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN PACIENTE PAC ON PAC.PACIENTEID = WL.PACIENTEID AND PAC.UNIDADEID = FAT.UNIDADEPACIENTEID ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN PROCEDIMENTOS PR ON PR.PROCID = FAT.PROCID ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN SETORES SE ON SE.SETORID = FAT.SETORID ";
        $sqlsrv = $sqlsrv . "LEFT JOIN MEDICOS TEC ON TEC.MEDICOID = FAT.TECNICOID ";
        $sqlsrv = $sqlsrv . "LEFT JOIN WORK_FILAS WF ON WF.FILAID = WL.FILAID ";
        $sqlsrv = $sqlsrv . "LEFT JOIN USUARIOS US ON US.USERID = FAT.USUARIO ";
        $sqlsrv = $sqlsrv . "WHERE WL.REQUISICAOID = '$requisicao_id'";
        $requisicoes = DB::connection('sqlsrv')->select($sqlsrv);
        return view('agendamento', ['requisicoes' => $requisicoes]);
    }

    public function getAgenda(Request $request)
    {
        $dataForm = $request->all();
        $data_req = $dataForm['data_req'];
        $paciente_id = $dataForm['paciente_id'];
        $sqlsrv = "Select TOP 1 A.PACIENTEID, FORMAT(A.DATA, 'yyyy/MM/dd') AS DATA, A.NOMEPAC AS PACIENTE, A.USERNAME AS ATENDENTE, A.USUARIO, A.NOME_EXAME AS PROCEDIMENTO FROM VW_AGENDA AS A ";
        $sqlsrv = $sqlsrv . "WHERE A.DATA = '$data_req' AND ";
        $sqlsrv = $sqlsrv . "A.PACIENTEID = '$paciente_id' AND ";
        $sqlsrv = $sqlsrv . "A.USERNAME IS NOT NULL";
        $agendas = DB::connection('sqlsrv')->select($sqlsrv);
        return view('agenda-data', ['agendas' => $agendas]);
    }
}
