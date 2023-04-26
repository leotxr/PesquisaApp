<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
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

    public function index()
    {
        $day = Rating::where('data_req', date('Y/m/d'))->count();
        $month = Rating::whereMonth('data_req', date('m'))->count();
        return view('admin.dashboard', ['day' => $day, 'month' => $month]);
    }

    public function create()
    {

        return view('welcome');
    }


    public static function store($requisicoes)
    {
        /*
        foreach ($requisicoes as $requisicao) {
            $rating = Rating::updateOrCreate([
                'pac_name' => $requisicao->PACIENTE ?? NULL,
                'pac_id' => $requisicao->PACIENTEID ?? NULL,
                'data_req' => $requisicao->DATA ?? NULL,
                'recep_name' => $requisicao->RECEPCIONISTA ?? NULL,
                'requisicao_id' => $requisicao->REQUISICAO ?? NULL
            ]);
        }

        if ($rating)
        return redirect()->action(
            [RatingController::class, 'edit'], [$rating]
        );
        else
            return redirect()->back()->withErrors('DEU CERTO NAO');
            */
    }



    public function edit(Rating $id)
    {
        $rating = Rating::find($id);

        return view('rate-recepcao', compact('rating'));
    }



    public function storeUltri(Request $request)
    {
        //$dataForm = $request->all();
        $id = $request->id;



        DB::table('ratings')
            ->where('id', $id)
            ->update([
                'nota_clinica' => $request->rate_clinica


            ]);
        return view('optional-coment', ['id' => $id]);
    }
    public function storeComent(Request $request)
    {
        //$dataForm = $request->all();
        $id = $request->id;
        $rating = Rating::find($id);
        if ($rating->finalizado == 1) {
            return redirect('welcome')
                ->withErrors('Essa pesquisa já foi finalizada. Não foi possível salvar novamente.')
                ->withInput();
        } else {
            DB::table('ratings')
                ->where('id', $id)
                ->update([
                    'comentario' => $request->comentario,
                    'finalizado' => 1
                ]);

            #$cookie = Cookie::forget('pesquisa_ultrimagem_session');

            return view('fim');
        }
    }

    public function editComent(Request $request)
    {
        //$dataForm = $request->all();
        $id = $request->id;

        for ($i = 0; $i < count($request->id); $i++) {
            DB::table('ratings')
                ->where('id', $id[$i])
                ->update([
                    'class_comentario' => $request->class_comentario[$i]
                ]);
        };
        return redirect()->back();
    }


    public function getDados(Request $request)
    {
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


    public function relatorioComentario(Request $request)
    {
        $dataForm = $request->all();
        $data_inicio = $request->data_inicio;
        $data_final = $request->data_final;
        $classificacao = $request->class_comentario;
        #$ordem = $dataForm['ordem'];

        $relcoment = DB::table('ratings')
            ->join('faturas', 'faturas.rating_id', '=', 'ratings.id')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->where('ratings.finalizado', 1)
            ->whereNotNull('ratings.comentario');

        if ($classificacao == 1) {
            $relcoment->where('ratings.class_comentario', 1);
        } elseif ($classificacao == 2) {
            $relcoment->where('ratings.class_comentario', 2);
        } elseif ($classificacao == 0) {
            $relcoment->where('ratings.class_comentario', 0);
        } elseif ($classificacao == 3) {
            $relcoment->where('ratings.class_comentario', 3);
        };


        $relcoment = $relcoment->get(['ratings.id', 'ratings.data_req', 'ratings.comentario', 'ratings.nota_clinica', 'ratings.class_comentario', 'faturas.setor', 'faturas.livro_name', 'faturas.tec_name']);

        return view('admin.tables.table-coment', ['relcoment' => $relcoment]);
    }

    public function report(Request $request)
    {
        $data_inicio = $request->data_inicio;
        $data_final = $request->data_final;

        //contador de pesquisas incompletas
        $total = Rating::where('finalizado', 1)
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        //INICIO NOTA CLINICA

        //contador de pesquisas no periodo
        $countratings = Rating::where('finalizado', 1)
            ->whereNotNull('nota_clinica')
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        //contador de notas positivas no periodo
        $countpositivas = Rating::where('finalizado', 1)
            ->where('nota_clinica', '>', 3)
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        //contador de notas positivas no periodo
        $countnegativas = Rating::where('finalizado', 1)
            ->where('nota_clinica', '<', 4)
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        //porcentagem nota clinica
        $prcntclinica = ($countpositivas / $countratings) * 100;

        $prcntclinicang = ($countnegativas / $countratings) * 100;

        //FIM NOTA CLINICA



        //INICIO NOTA AGENDAMENTO TELEFONIA

        //contador de notas positivas no periodo
        $agpositivas = Rating::where('finalizado', 1)
            ->where('atend_rate', '>', 3)
            ->whereNotIn('grp_agendamento', [45, 34])
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        //contador de notas negativas
        $agnegativas = Rating::where('finalizado', 1)
            ->where('atend_rate', '<', 4)
            ->whereNotIn('grp_agendamento', [45, 34])
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');


        //contador de pesquisas no periodo
        $countagenda = Rating::where('finalizado', 1)
            ->whereNotNull('atend_rate')
            ->whereNotIn('grp_agendamento', [45, 34])
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        //porcentagem nota clinica
        $prcntagenda = ($agpositivas / $countagenda) * 100;
        $prcntagendang = ($agnegativas / $countagenda) * 100;


        //FIM NOTA AGENDAMENTO

        //INICIO NOTA AGENDAMENTO RECEPCAO

        //contador de notas positivas no periodo
        $agreceppositivas = Rating::where('finalizado', 1)
            ->where('atend_rate', '>', 3)
            ->whereIn('grp_agendamento', [45, 34])
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        //contador de notas negativas
        $agrecepnegativas = Rating::where('finalizado', 1)
            ->where('atend_rate', '<', 4)
            ->whereIn('grp_agendamento', [45, 34])
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');


        //contador de pesquisas no periodo
        $countagendarecep = Rating::where('finalizado', 1)
            ->whereNotNull('atend_rate')
            ->whereIn('grp_agendamento', [45, 34])
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        //porcentagem nota clinica
        $prcntagendarecep = ($agreceppositivas / $countagendarecep) * 100;
        $prcntagendarecepng = ($agrecepnegativas / $countagendarecep) * 100;

        //FIM NOTA AGENDAMENTO




        //INICIO NOTA RECEPCAO

        //contador de notas positivas no periodo
        $recpositivas = Rating::where('finalizado', 1)
            ->where('recep_rate', '>', 3)
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        $recnegativas = Rating::where('finalizado', 1)
            ->where('recep_rate', '<', 4)
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        //contador de pesquisas no periodo
        $countrecep = Rating::where('finalizado', 1)
            ->whereNotNull('recep_rate')
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('id');

        //porcentagem nota recepcionista
        $prcntrecep = ($recpositivas / $countrecep) * 100;
        $prcntrecepng = ($recnegativas / $countrecep) * 100;

        //FIM NOTA RECEPCAO

        //INICIO NOTA RECEPCIONISTA USG
        $countusg = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->whereNotNull('us_rate')
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('us_rate');

        $usgpositivas = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->where('faturas.us_rate', '>', 3)
            ->whereNotNull('faturas.us_rate')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->count('us_rate');

        $usgnegativas = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->where('faturas.us_rate', '<', 4)
            ->whereNotNull('faturas.us_rate')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->count('us_rate');

        $prcntusg = ($usgpositivas / $countusg) * 100;
        $prcntusgng = ($usgnegativas / $countusg) * 100;

        //fim NOTA RECEPCIONISTA USG

        //INICIO NOTA ENFERMAGEM
        $countenf = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->whereNotNull('enf_rate')
            ->whereBetween('data_req', [$data_inicio, $data_final])
            ->count('enf_rate');

        $enfpositivas = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->where('faturas.enf_rate', '>', 3)
            ->whereNotNull('faturas.enf_rate')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->count('enf_rate');

        $enfnegativas = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->where('faturas.enf_rate', '<', 4)
            ->whereNotNull('faturas.enf_rate')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->count('enf_rate');

        $prcntenf = ($enfpositivas / $countenf) * 100;
        $prcntenfng = ($enfnegativas / $countenf) * 100;

        //fim NOTA ENFERMAGEM

        //INICIO NOTA TECNICOS
        $counttec = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->whereNotNull('faturas.livro_rate')
            ->whereNotNull('faturas.tec_name')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->count('tec_name');

        $tecpositivas = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->where('faturas.livro_rate', '>', 3)
            ->whereNotNull('faturas.livro_rate')
            ->whereNotNull('faturas.tec_name')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->count('tec_name');

        $tecnegativas = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->where('faturas.livro_rate', '<', 4)
            ->whereNotNull('faturas.livro_rate')
            ->whereNotNull('faturas.tec_name')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->count('tec_name');

        $prcnttec = ($tecpositivas / $counttec) * 100;
        $prcnttecng = ($tecnegativas / $counttec) * 100;

        //fim NOTA TECNICOS

        //INICIO NOTA MEDICOS
        $countmed = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->whereIn('faturas.setor', ['ULTRA-SON', 'CARDIOLOGIA'])
            ->whereNotNull('faturas.livro_rate')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->count('livro_rate');

        $medpositivas = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->whereIn('faturas.setor', ['ULTRA-SON', 'CARDIOLOGIA'])
            ->where('faturas.livro_rate', '>', 3)
            ->whereNotNull('faturas.livro_rate')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->count('livro_rate');

        $mednegativas = Fatura::join('ratings', 'ratings.id', '=', 'faturas.rating_id')
            ->where('ratings.finalizado', 1)
            ->whereIn('faturas.setor', ['ULTRA-SON', 'CARDIOLOGIA'])
            ->where('faturas.livro_rate', '<', 4)
            ->whereNotNull('faturas.livro_rate')
            ->whereBetween('ratings.data_req', [$data_inicio, $data_final])
            ->count('livro_rate');

        $prcntmed = ($medpositivas / $countmed) * 100;
        $prcntmedng = ($mednegativas / $countmed) * 100;

        //fim NOTA TECNICOS



        return view('admin.tables.reports', compact(
            'data_inicio',
            'data_final',
            'countratings',
            'countpositivas',
            'countnegativas',
            'prcntclinica',
            'prcntclinicang',
            'recpositivas',
            'recnegativas',
            'countrecep',
            'prcntrecep',
            'prcntrecepng',
            'agpositivas',
            'agnegativas',
            'countagenda',
            'prcntagenda',
            'prcntagendang',
            'agreceppositivas',
            'agrecepnegativas',
            'countagendarecep',
            'prcntagendarecep',
            'prcntagendarecepng',
            'total',
            'countusg',
            'usgpositivas',
            'usgnegativas',
            'prcntusg',
            'prcntusgng',
            'countenf',
            'enfpositivas',
            'enfnegativas',
            'prcntenf',
            'prcntenfng',
            'counttec',
            'tecpositivas',
            'tecnegativas',
            'prcnttec',
            'prcnttecng',
            'countmed',
            'medpositivas',
            'mednegativas',
            'prcntmed',
            'prcntmedng'
        ));
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
