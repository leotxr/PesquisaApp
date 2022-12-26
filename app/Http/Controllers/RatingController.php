<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rating;
use App\Models\Fatura;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Symfony\Component\Finder\Finder;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->objRating = new Rating();
    }

    public function create()
    {

        return view('welcome');
    }
    #ARMAZENA AS INFORMACOES INICIAIS DO ATENDIMENTO
    public function storeAgendamento(Request $request)
    {

        $cad = DB::table('ratings')->insert([
            //'grp_agendamento' => $request->grupo_id,
            'data_req' => $request->data_req,
            'id' => $request->id,
            'pac_id' => $request->paciente_id,
            'pac_name' => $request->paciente_name,
        ]);

        #SE ARMAZENAR, REALIZA UM SELECT NA AGENDA PARA PEGAR OS DADOS DO AGENDAMENTO
        if ($cad) {
            $dataForm = $request->all();
            $data_req = $dataForm['data_req'];
            $paciente_id = $dataForm['paciente_id'];
            $requisicao = $dataForm['id'];
            $sqlsrv = "Select TOP 1 A.PACIENTEID, FORMAT(A.DATA, 'yyyy/MM/dd') AS DATA, G.GRUPOID, A.NOMEPAC AS PACIENTE, U.NOME_SOCIAL AS ATENDENTE, A.USUARIO, A.NOME_EXAME AS PROCEDIMENTO FROM VW_AGENDA AS A ";
            $sqlsrv = $sqlsrv . "INNER JOIN USUARIOS AS U ON U.USERID = A.USUARIO ";
            $sqlsrv = $sqlsrv . "INNER JOIN USUARIOSGRUPOS G ON G.GRUPOID = U.GRUPOID ";
            $sqlsrv = $sqlsrv . "WHERE A.DATA = '$data_req' AND ";
            $sqlsrv = $sqlsrv . "A.PACIENTEID = '$paciente_id' AND ";
            $sqlsrv = $sqlsrv . "A.USERNAME IS NOT NULL";
            $agendas = DB::connection('sqlsrv')->select($sqlsrv);
            return view('agenda-data', ['agendas' => $agendas, 'requisicao' => $requisicao]);
        } else {
            return redirect()->back()
                ->withErrors('Código não encontrado! Verifique seu protocolo e tente novamente.')
                ->withInput();
        }
    }

    public function edit(Rating $id)
    {
        $avaliacao = Rating::find($id);

        return view('avaliar', compact('avaliacao'));
    }

    public function editAgenda(Rating $id)
    {
        $avaliacao = Rating::find($id);

        return view('agenda-data', compact('agendas'));
    }


    #ARMAZENA INFORMACOES DO AGENDAMENTO NA TABELA
    public function storeAgenda(Request $request)
    {
        $dataForm = $request->all();

        $id = $dataForm['id'];


        $agendas = DB::table('ratings')
            ->where('id', $id)
            ->update([
                'grp_agendamento' => $request->grupo_id,
                'atend_name' => $request->atendente_name,
                'atend_rate' => $request->rating1
            ]);

        #SE ARMAZENAR, REALIZA UM SELECT NA WORKLIST NOVAMENTE
        if ($agendas) {

            $sqlsrv = "Select TOP 1 WL.REQUISICAOID AS REQUISICAO, SE.DESCRICAO AS SETOR, US.NOME_SOCIAL AS RECEPCIONISTA from WORK_LIST AS WL ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN FATURA FAT ON FAT.FATURAID = WL.FATURAID AND FAT.UNIDADEID = WL.UNIDADEID AND FAT.PACIENTEID = WL.PACIENTEID ";
            #$sqlsrv = $sqlsrv . "LEFT OUTER JOIN PACIENTE PAC ON PAC.PACIENTEID = WL.PACIENTEID AND PAC.UNIDADEID = FAT.UNIDADEPACIENTEID ";
            #$sqlsrv = $sqlsrv . "LEFT OUTER JOIN PROCEDIMENTOS PR ON PR.PROCID = FAT.PROCID ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN SETORES SE ON SE.SETORID = FAT.SETORID ";
            #$sqlsrv = $sqlsrv . "LEFT JOIN MEDICOS TEC ON TEC.MEDICOID = FAT.TECNICOID ";
            #$sqlsrv = $sqlsrv . "LEFT JOIN WORK_FILAS WF ON WF.FILAID = WL.FILAID ";
            $sqlsrv = $sqlsrv . "LEFT JOIN USUARIOS US ON US.USERID = FAT.USUARIO ";
            $sqlsrv = $sqlsrv . "WHERE WL.REQUISICAOID = '$id'";
            $requisicoes = DB::connection('sqlsrv')->select($sqlsrv);
            return view('rate-recepcao', ['requisicoes' => $requisicoes, 'id' => $id]);
        }
    }

    public function storeRecepcao(Request $request)
    {
        $dataForm = $request->all();

        $id = $dataForm['id'];



        $recep = DB::table('ratings')
            ->where('id', $id)
            ->update([
                'recep_name' => $request->recepcionista_name,
                'recep_rate' => $request->rating2,

            ]);

        #SE ARMAZENAR, REALIZA UM SELECT NA WORKLIST NOVAMENTE
        if ($recep) {

            $sqlsrv = "Select DISTINCT FORMAT(FAT.DATA, 'yyyy/MM/dd') AS DATA, WL.REQUISICAOID AS REQUISICAO, SE.DESCRICAO AS SETOR, TEC.NOME_SOCIAL AS TECNICO, WF.FILANOME AS MEDICO from WORK_LIST AS WL ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN FATURA FAT ON FAT.FATURAID = WL.FATURAID AND FAT.UNIDADEID = WL.UNIDADEID AND FAT.PACIENTEID = WL.PACIENTEID ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN PACIENTE PAC ON PAC.PACIENTEID = WL.PACIENTEID AND PAC.UNIDADEID = FAT.UNIDADEPACIENTEID ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN SETORES SE ON SE.SETORID = FAT.SETORID ";
            $sqlsrv = $sqlsrv . "LEFT JOIN MEDICOS TEC ON TEC.MEDICOID = FAT.TECNICOID ";
            $sqlsrv = $sqlsrv . "LEFT JOIN WORK_FILAS WF ON WF.FILAID = WL.FILAID ";
            $sqlsrv = $sqlsrv . "WHERE WL.REQUISICAOID = '$id' ";
            $requisicoes = DB::connection('sqlsrv')->select($sqlsrv);

            $sqlsrv2 = "Select DISTINCT O.DATA AS DATA, F.REQUISICAOID, SE.DESCRICAO, USU.NOME_SOCIAL AS USUARIO ";
            $sqlsrv2 = $sqlsrv2 . "FROM RASOCORRENCIAS O ";
            $sqlsrv2 = $sqlsrv2 . "LEFT OUTER JOIN FATURA F ON O.PACIENTEID=F.PACIENTEID AND O.UNIDADEID=F.UNIDADEID AND O.FATURAID=F.FATURAID ";
            $sqlsrv2 = $sqlsrv2 . "LEFT OUTER JOIN USUARIOS USU ON (O.USERID = USU.USERID) ";
            $sqlsrv2 = $sqlsrv2 . "LEFT OUTER JOIN SETORES SE ON (SE.SETORID = F.SETORID) ";
            $sqlsrv2 = $sqlsrv2 . "WHERE O.RASEVENTOID IN (39) AND SE.DESCRICAO IN ('ULTRA-SON', 'CARDIOLOGIA') AND F.REQUISICAOID = '$id' ";
            $recepus = DB::connection('sqlsrv')->select($sqlsrv2);

            $sqlsrv3 = "Select TOP 1 US.NOME_SOCIAL AS ENFERMEIRA, WL.REQUISICAOID FROM RASOCORRENCIAS AS RA ";
            $sqlsrv3 = $sqlsrv3 . "INNER JOIN WORK_LIST AS WL ON WL.PACIENTEID = RA.PACIENTEID AND WL.DATA = RA.DATA ";
            $sqlsrv3 = $sqlsrv3 . "INNER JOIN USUARIOS AS US ON US.USERID = RA.USERID ";
            $sqlsrv3 = $sqlsrv3 . "WHERE RA.RASEVENTOID = 250003 AND WL.REQUISICAOID = '$id' ";
            $enfermeiras = DB::connection('sqlsrv')->select($sqlsrv3);



            return view('rate-med', ['requisicoes' => $requisicoes, 'recepus' => $recepus, 'enfermeiras' => $enfermeiras, 'rating_id' => $id]);
        }
    }

    public function storeUltri(Request $request)
    {
        $dataForm = $request->all();
        $id = $dataForm['id'];



        DB::table('ratings')
            ->where('id', $id)
            ->update([
                'nota_clinica' => $request->rate_clinica,
                'finalizado' => 1
            ]);
        return view('optional-coment', ['id' => $id]);
    }
    public function storeComent(Request $request)
    {
        $dataForm = $request->all();
        $id = $dataForm['id'];

        DB::table('ratings')
            ->where('id', $id)
            ->update([
                'comentario' => $request->comentario
            ]);
        return view('fim');
    }


    public function getDados(Request $request)
    {
        $dataForm = $request->all();

        $request->validate([
            'id' => 'required|unique:ratings|max:10',
        ]);

        $requisicao_id = $dataForm['id'];
        $sqlsrv = "Select TOP 1 FORMAT(FAT.DATA, 'yyyy/MM/dd') AS DATA, WL.REQUISICAOID AS REQUISICAO, FAT.PACIENTEID AS PACIENTEID, PAC.NOME AS PACIENTE, PR.DESCRICAO AS PROCEDIMENTO, SE.DESCRICAO AS SETOR, TEC.NOME AS TECNICO, WF.FILANOME AS MEDICO, US.NOME_SOCIAL AS RECEPCIONISTA, FAT.REQUISICAOID from WORK_LIST AS WL ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN FATURA FAT ON FAT.FATURAID = WL.FATURAID AND FAT.UNIDADEID = WL.UNIDADEID AND FAT.PACIENTEID = WL.PACIENTEID ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN PACIENTE PAC ON PAC.PACIENTEID = WL.PACIENTEID AND PAC.UNIDADEID = FAT.UNIDADEPACIENTEID ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN PROCEDIMENTOS PR ON PR.PROCID = FAT.PROCID ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN SETORES SE ON SE.SETORID = FAT.SETORID ";
        $sqlsrv = $sqlsrv . "LEFT JOIN MEDICOS TEC ON TEC.MEDICOID = FAT.TECNICOID ";
        $sqlsrv = $sqlsrv . "LEFT JOIN WORK_FILAS WF ON WF.FILAID = WL.FILAID ";
        $sqlsrv = $sqlsrv . "LEFT JOIN USUARIOS US ON US.USERID = FAT.USUARIO ";
        $sqlsrv = $sqlsrv . "WHERE WL.REQUISICAOID = '$requisicao_id'";
        $requisicoes = DB::connection('sqlsrv')->select($sqlsrv);

        if ($requisicoes) {
            return view('agendamento', ['requisicoes' => $requisicoes]);
        } else {
            return redirect()->back()
                ->withErrors('Código não encontrado! Verifique seu protocolo e tente novamente.')
                ->withInput();
        }
    }

    public function getAgenda(Request $request)
    {
        $dataForm = $request->all();
        $data_req = $dataForm['data_req'];
        $paciente_id = $dataForm['paciente_id'];
        $sqlsrv = "Select TOP 1 A.PACIENTEID, FORMAT(A.DATA, 'yyyy/MM/dd') AS DATA, A.NOMEPAC AS PACIENTE, U.NOME_SOCIAL AS ATENDENTE, A.USUARIO, A.NOME_EXAME AS PROCEDIMENTO FROM VW_AGENDA AS A ";
        $sqlsrv = $sqlsrv . "WHERE A.DATA = '$data_req' AND ";
        $sqlsrv = $sqlsrv . "A.PACIENTEID = '$paciente_id' AND ";
        $sqlsrv = $sqlsrv . "A.USERNAME IS NOT NULL";
        $agendas = DB::connection('sqlsrv')->select($sqlsrv);
        return view('agenda-data', ['agendas' => $agendas]);
    }




    public function todayRatings()
    {
        $hoje = date('d/m/Y');
        $hojeconvert = date('Y/m/d');

        $todays = DB::table('ratings')->where('data_req', $hojeconvert)->count('nota_clinica');
        $avg = DB::table('ratings')->where('data_req', $hojeconvert)->avg('nota_clinica');
        $exams = DB::table('faturas')->where('fatura_data', $hojeconvert)->count('id');
        return view('admin.stats.ratings-hoje', ['todays' => $todays, 'hoje' => $hoje, 'avg' => $avg, 'exams' => $exams]);
    }

    public function monthRatings()
    {
        $hoje = date('F');
        $hojeconvert = date('Y/m/d');
        $iniciomes = date('m');

        $month = DB::table('ratings')->whereMonth('data_req', $iniciomes)->count('id');
        $avg = DB::table('ratings')->whereMonth('data_req', $iniciomes)->avg('nota_clinica');
        $exams = DB::table('faturas')->where('fatura_data', $hojeconvert)->count('id');
        return view('admin.stats.ratings-mes', ['month' => $month, 'hoje' => $hoje, 'avg' => $avg, 'exams' => $exams]);
    }

    public function yearRatings()
    {
        $hoje = date('d/m/Y');
        $hojeconvert = date('Y/m/d');
        $inicioano = date('Y');

        $year = DB::table('ratings')->whereYear('data_req', $inicioano)->count('id');
        $avg = DB::table('ratings')->whereYear('data_req', $inicioano)->avg('nota_clinica');
        $exams = DB::table('faturas')->where('fatura_data', $hojeconvert)->count('id');
        return view('admin.stats.ratings-ano', ['year' => $year, 'hoje' => $hoje, 'avg' => $avg, 'exams' => $exams]);
    }

    public function countRatings()
    {
        $hoje = date('d/m/Y');
        $hojeconvert = date('Y/m/d');

        $positivas = DB::table('ratings')->where('nota_clinica', '>', '3')->count('nota_clinica');
        $neutras = DB::table('ratings')->where('nota_clinica', '=', '3')->count('nota_clinica');
        $negativas = DB::table('ratings')->where('nota_clinica', '<', '3')->count('nota_clinica');
        $avg = DB::table('ratings')->where('data_req', $hojeconvert)->avg('nota_clinica');
        $exams = DB::table('faturas')->where('fatura_data', $hojeconvert)->count('id');
        return view('admin.stats.stats-clinica', ['positivas' => $positivas, 'neutras' => $neutras, 'negativas' => $negativas]);
    }

    public function totalRatings()
    {
        $hoje = date('d/m/Y');
        $hojeconvert = date('Y/m/d');

        $ratings = DB::table('ratings')->count('id');
        $avg = DB::table('ratings')->avg('nota_clinica');
        $exams = DB::table('faturas')->count('id');
        return view('admin.ratings-hoje', ['ratings' => $ratings, 'hoje' => $hoje, 'avg' => $avg, 'exams' => $exams]);
    }

    public function relatorioGeral(Request $request)
    {
        $dataForm = $request->all();
        $data_inicio = $request->data_inicio;
        $data_final = $request->data_final;
        $ordem = $dataForm['ordem'];

        $sql = "select RA.data_req as DATA, RA.pac_name AS PACIENTE, RA.atend_name AS ATENDENTE, RA.atend_rate AS NOTA_ATENDENTE, RA.recep_name AS RECEPCIONISTA, RA.recep_rate AS NOTA_RECEPCIONISTA, ";
        $sql = $sql . "FA.med_name AS MEDICO, FA.med_rate AS NOTA_MEDICO, FA.setor AS SETOR, RA.nota_clinica AS ULTRIMAGEM ";
        $sql = $sql . "FROM faturas as FA INNER JOIN ratings as RA on RA.id = FA.rating_id ";
        $sql = $sql . "WHERE RA.data_req BETWEEN '$data_inicio' and '$data_final' ORDER BY $ordem";
        $relgeral = DB::connection('mysql')->select($sql);

        $avg = DB::table('ratings')
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->avg('nota_clinica');

        return view('admin.tables.table-geral', ['relgeral' => $relgeral, 'avg' => $avg]);
    }

    public function relatorioComentario(Request $request)
    {
        $dataForm = $request->all();
        $data_inicio = $request->data_inicio;
        $data_final = $request->data_final;
        #$ordem = $dataForm['ordem'];

        $relcoment = DB::table('ratings')
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->whereNotNull('comentario')
            ->get();
        return view('admin.tables.table-coment', ['relcoment' => $relcoment]);
    }

    public function teste(Request $request)
    {
        $data_inicio = $request->data_inicio;
        $data_final = $request->data_final;
        $results = DB::table('faturas')
            ->join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->whereBetween('ratings.data_req', $data_inicio, 'between', $data_final)
            ->select('ratings.data_req AS DATA', 'ratings.pac_nome AS PACIENTE', 'orders.price')
            ->get();
    }

    public function showdatepicker()
    {
        $rating = DB::table('faturas')
            ->select('med_name')
            ->distinct()
            ->orderBy('med_name')
            ->get();
        return view('admin.date-picker', compact('rating'));
    }
}
