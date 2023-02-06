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
        #$this->objRating = new Rating();
    }

    public function create()
    {

        return view('welcome');
    }


    public function store(Request $request)
    {
        $rating = Rating::create([
            'pac_name' => $request->paciente_name ?? NULL,
            'pac_id' => $request->paciente_id ?? NULL,
            'grp_agendamento' => $request->grupo_id ?? NULL,
            'data_req' => $request->data_req ?? NULL,
            'atend_name' => $request->atendente_name ?? NULL,
            'atend_rate' => $request->rating1 ?? NULL,
            'recep_name' => $request->recepcionista_name ?? NULL,
            'recep_rate' => $request->rating2 ?? NULL,
            'tipo_atraso' => $request->horario ?? NULL,
            'requisicao_id' => $request->requisicao_id ?? NULL

        ]);

        if ($rating) {

            $sqlsrv = "Select DISTINCT FORMAT(FAT.DATA, 'yyyy/MM/dd') AS DATA, WL.REQUISICAOID AS REQUISICAO, SE.DESCRICAO AS SETOR, TEC.NOME_SOCIAL AS TECNICO, WF.FILANOME AS MEDICO from WORK_LIST AS WL ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN FATURA FAT ON FAT.FATURAID = WL.FATURAID AND FAT.UNIDADEID = WL.UNIDADEID AND FAT.PACIENTEID = WL.PACIENTEID ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN PACIENTE PAC ON PAC.PACIENTEID = WL.PACIENTEID AND PAC.UNIDADEID = FAT.UNIDADEPACIENTEID ";
            $sqlsrv = $sqlsrv . "LEFT OUTER JOIN SETORES SE ON SE.SETORID = FAT.SETORID ";
            $sqlsrv = $sqlsrv . "LEFT JOIN MEDICOS TEC ON TEC.MEDICOID = FAT.TECNICOID ";
            $sqlsrv = $sqlsrv . "LEFT JOIN WORK_FILAS WF ON WF.FILAID = WL.FILAID ";
            $sqlsrv = $sqlsrv . "WHERE WL.REQUISICAOID = '$rating->requisicao_id' ";
            $requisicoes = DB::connection('sqlsrv')->select($sqlsrv);

            $sqlsrv2 = "Select DISTINCT O.DATA AS DATA, F.REQUISICAOID, SE.DESCRICAO, USU.NOME_SOCIAL AS USUARIO ";
            $sqlsrv2 = $sqlsrv2 . "FROM RASOCORRENCIAS O ";
            $sqlsrv2 = $sqlsrv2 . "LEFT OUTER JOIN FATURA F ON O.PACIENTEID=F.PACIENTEID AND O.UNIDADEID=F.UNIDADEID AND O.FATURAID=F.FATURAID ";
            $sqlsrv2 = $sqlsrv2 . "LEFT OUTER JOIN USUARIOS USU ON (O.USERID = USU.USERID) ";
            $sqlsrv2 = $sqlsrv2 . "LEFT OUTER JOIN SETORES SE ON (SE.SETORID = F.SETORID) ";
            $sqlsrv2 = $sqlsrv2 . "WHERE O.RASEVENTOID IN (39) AND SE.DESCRICAO IN ('ULTRA-SON', 'CARDIOLOGIA') AND F.REQUISICAOID = '$rating->requisicao_id' ";
            $recepus = DB::connection('sqlsrv')->select($sqlsrv2);

            $sqlsrv3 = "Select TOP 1 US.NOME_SOCIAL AS ENFERMEIRA, WL.REQUISICAOID FROM RASOCORRENCIAS AS RA ";
            $sqlsrv3 = $sqlsrv3 . "INNER JOIN WORK_LIST AS WL ON WL.PACIENTEID = RA.PACIENTEID AND WL.DATA = RA.DATA ";
            $sqlsrv3 = $sqlsrv3 . "INNER JOIN USUARIOS AS US ON US.USERID = RA.USERID ";
            $sqlsrv3 = $sqlsrv3 . "WHERE RA.RASEVENTOID = 250003 AND WL.REQUISICAOID = '$rating->requisicao_id' ";
            $enfermeiras = DB::connection('sqlsrv')->select($sqlsrv3);



            return view('rate-med', ['requisicoes' => $requisicoes, 'recepus' => $recepus, 'enfermeiras' => $enfermeiras, 'requisicao_id' => $rating->requisicao_id, 'rating_id' => $rating->id]);
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


    public function storeUltri(Request $request)
    {
        //$dataForm = $request->all();
        $id = $request->id;



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
        //$dataForm = $request->all();
        $id = $request->id;

        DB::table('ratings')
            ->where('id', $id)
            ->update([
                'comentario' => $request->comentario
            ]);
        return view('fim');
    }


    public function getDados(Request $request)
    {
        $data = date('Y/m/d');
        #$datainicio = date('Y/m/d', strtotime('-7 days'));
        $paciente_id = $request->pacienteid;

        $sqlsrv = "Select TOP 1 FORMAT(FAT.DATA, 'yyyy/MM/dd') AS DATA, WL.REQUISICAOID AS REQUISICAO, FAT.PACIENTEID AS PACIENTEID, PAC.NOME AS PACIENTE, PR.DESCRICAO AS PROCEDIMENTO, SE.DESCRICAO AS SETOR, TEC.NOME AS TECNICO, WF.FILANOME AS MEDICO, US.NOME_SOCIAL AS RECEPCIONISTA, FAT.REQUISICAOID from WORK_LIST AS WL ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN FATURA FAT ON FAT.FATURAID = WL.FATURAID AND FAT.UNIDADEID = WL.UNIDADEID AND FAT.PACIENTEID = WL.PACIENTEID ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN PACIENTE PAC ON PAC.PACIENTEID = WL.PACIENTEID AND PAC.UNIDADEID = FAT.UNIDADEPACIENTEID ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN PROCEDIMENTOS PR ON PR.PROCID = FAT.PROCID ";
        $sqlsrv = $sqlsrv . "LEFT OUTER JOIN SETORES SE ON SE.SETORID = FAT.SETORID ";
        $sqlsrv = $sqlsrv . "LEFT JOIN MEDICOS TEC ON TEC.MEDICOID = FAT.TECNICOID ";
        $sqlsrv = $sqlsrv . "LEFT JOIN WORK_FILAS WF ON WF.FILAID = WL.FILAID ";
        $sqlsrv = $sqlsrv . "LEFT JOIN USUARIOS US ON US.USERID = FAT.USUARIO ";
        $sqlsrv = $sqlsrv . "WHERE WL.PACIENTEID = '$paciente_id' AND FAT.DATA = '$data' ";
        $requisicoes = DB::connection('sqlsrv')->select($sqlsrv);

        $sqlsrv_a = "Select TOP 1 A.PACIENTEID, FORMAT(A.DATA, 'yyyy/MM/dd') AS DATA, G.GRUPOID, A.NOMEPAC AS PACIENTE, U.NOME_SOCIAL AS ATENDENTE, A.USUARIO, A.NOME_EXAME AS PROCEDIMENTO FROM VW_AGENDA AS A ";
        $sqlsrv_a = $sqlsrv_a . "INNER JOIN USUARIOS AS U ON U.USERID = A.USUARIO ";
        $sqlsrv_a = $sqlsrv_a . "INNER JOIN USUARIOSGRUPOS G ON G.GRUPOID = U.GRUPOID ";
        $sqlsrv_a = $sqlsrv_a . "WHERE A.DATA = '$data' AND ";
        $sqlsrv_a = $sqlsrv_a . "A.PACIENTEID = '$paciente_id' AND ";
        $sqlsrv_a = $sqlsrv_a . "A.USERNAME IS NOT NULL";
        $agendas = DB::connection('sqlsrv')->select($sqlsrv_a);

        if ($requisicoes) {
            return view('agendamento', ['requisicoes' => $requisicoes, 'agendas' => $agendas]);
        } else {
            return redirect()->back()
                ->withErrors('Código não encontrado! Verifique seu protocolo e tente novamente.')
                ->withInput();
        }
    }



    public function todayRatings()
    {
        $hoje = date('d/m/Y');
        $hojeconvert = date('Y/m/d');

        $todays = DB::table('ratings')->where('data_req', $hojeconvert)->where('finalizado', '=', 1)->count('id');
        $avg = DB::table('ratings')->where('data_req', $hojeconvert)->where('finalizado', '=', 1)->avg('nota_clinica');
        $exams = DB::table('faturas')->where('fatura_data', $hojeconvert)->count('id');
        return view('admin.stats.ratings-hoje', ['todays' => $todays, 'hoje' => $hoje, 'avg' => $avg, 'exams' => $exams]);
    }

    public function monthRatings()
    {
        $hoje = date('F');
        $hojeconvert = date('Y/m/d');
        $iniciomes = date('m');

        $month = DB::table('ratings')->whereMonth('data_req', $iniciomes)->where('finalizado', '=', 1)->count('id');
        $avg = DB::table('ratings')->whereMonth('data_req', $iniciomes)->where('finalizado', '=', 1)->avg('nota_clinica');
        $exams = DB::table('faturas')->where('fatura_data', $hojeconvert)->count('id');
        return view('admin.stats.ratings-mes', ['month' => $month, 'hoje' => $hoje, 'avg' => $avg, 'exams' => $exams]);
    }

    public function yearRatings()
    {
        $hoje = date('d/m/Y');
        $hojeconvert = date('Y/m/d');
        $inicioano = date('Y');

        $year = DB::table('ratings')->whereYear('data_req', $inicioano)->where('finalizado', '=', 1)->count('id');
        $avg = DB::table('ratings')->whereYear('data_req', $inicioano)->where('finalizado', '=', 1)->avg('nota_clinica');
        $exams = DB::table('faturas')->where('fatura_data', $hojeconvert)->count('id');
        return view('admin.stats.ratings-ano', ['year' => $year, 'hoje' => $hoje, 'avg' => $avg, 'exams' => $exams]);
    }

    public function countRatings()
    {
        $hoje = date('d/m/Y');
        $hojeconvert = date('Y/m/d');

        $positivas = DB::table('ratings')->where('nota_clinica', '>=', '4')->count('nota_clinica');
        $negativas = DB::table('ratings')->where('nota_clinica', '<=', '3')->count('nota_clinica');
        $avg = DB::table('ratings')->where('data_req', $hojeconvert)->avg('nota_clinica');
        $exams = DB::table('faturas')->where('fatura_data', $hojeconvert)->count('id');
        return view('admin.stats.stats-clinica', ['positivas' => $positivas, 'negativas' => $negativas]);
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
        $sql = $sql . "FA.livro_name AS LIVRO, FA.livro_rate AS NOTA_LIVRO, FA.setor AS SETOR, RA.nota_clinica AS ULTRIMAGEM ";
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
            ->select('setor')
            ->distinct()
            ->orderBy('setor')
            ->get();
        return view('admin.date-picker', compact('rating'));
    }

}
