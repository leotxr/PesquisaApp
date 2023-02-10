<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rating;
use App\Models\Fatura;

class FaturaController extends Controller
{
    private $fatura;

    public function __construct()
    {
        $this->fatura = new Fatura();
    }


    public function store(Request $request)
    {
        for ($i = 0; $i < count($request->rating_id); $i++) {
            $fatura = Fatura::create([
                'rating_id' => $request->rating_id[$i] ?? NULL,
                'requisicao_id' => $request->requisicao_id[$i] ?? NULL,
                'fatura_data' => $request->data_fatura[$i] ?? NULL,
                'livro_name' => $request->medico_name[$i] ?? NULL,
                'livro_rate' => $request->med_rate[$i] ?? NULL,
                #'grp_livro' => $request->grp_livro[$i]??NULL,
                'tec_name' => $request->tecnico_name[$i] ?? NULL,
                'us_name' => $request->us_name[$i] ?? NULL,
                'us_rate' => $request->us_rate[$i] ?? NULL,
                'enf_name' => $request->enf_name[$i] ?? NULL,
                'enf_rate' => $request->enf_rate[$i] ?? NULL,
                'setor' => $request->setor[$i] ?? NULL
            ]);
        };

        DB::table('ratings')
            ->where('id', $fatura->rating_id)
            ->update([
                'recomenda' => $request->rec_rate
            ]);

        return view('rate-ultri', ['rating_id' => $request->rating_id]);
    }


    public function relatorioUSG1(Request $request)
    {
        $dataForm = $request->all();
        $data_inicio = $request->data_inicio;
        $data_final = $request->data_final;
        $livro_name = $dataForm['livro_name'];
        $ordem = $dataForm['ordem'];

        $sql = "select RA.data_req as DATA, RA.pac_name AS PACIENTE, ";
        $sql = $sql . "FA.livro_name AS MEDICO, FA.livro_rate AS NOTA_MEDICO, FA.setor AS SETOR, RA.nota_clinica AS ULTRIMAGEM ";
        $sql = $sql . "FROM faturas as FA INNER JOIN ratings as RA on RA.id = FA.req_id ";
        $sql = $sql . "WHERE FA.med_name LIKE('$livro_name') and RA.data_req BETWEEN '$data_inicio' and '$data_final' ORDER BY $ordem";
        $relusg = DB::connection('mysql')->select($sql);
        return view('admin.tables.table-usg', ['relusg' => $relusg]);
    }

    public function relatorioSetores(Request $request)
    {
        $dataForm = $request->all();
        $data_inicio = $request->data_inicio;
        $data_final = $request->data_final;
        $ordem = $dataForm['ordem'];
        $setores = $dataForm['setores'];
        $nota = $dataForm['nota'];

        switch ($setores) {
            case 1:

                $query = DB::table('faturas')
                    ->whereIn('faturas.setor', ['ULTRA-SON', 'CARDIOLOGIA'])
                    ->whereBetween('data_req', [$data_inicio, $data_final]);

                if ($nota == 1) {
                    $query->where('ratings.finalizado', 1)
                        ->where(function ($query) {
                            $query->where('ratings.nota_clinica', '>', 3)
                                ->orWhere('ratings.recep_rate', '>', 3)
                                ->orWhere('ratings.atend_rate', '>', 3)
                                ->orWhere('faturas.livro_rate', '>', 3)
                                ->orWhere('faturas.us_rate', '>', 3);
                        });
                } elseif ($nota == 2) {
                    $query->where('ratings.finalizado', 1)
                        ->where(function ($query) {
                            $query->where('ratings.nota_clinica', '<', 4)
                                ->orWhere('ratings.recep_rate', '<', 4)
                                ->orWhere('ratings.atend_rate', '<', 4)
                                ->orWhere('faturas.livro_rate', '<', 4)
                                ->orWhere('faturas.us_rate', '<', 4);
                        });
                };

                $setor = $query->join('ratings', 'ratings.id', '=', 'faturas.rating_id')
                    ->orderBy($ordem)
                    ->get();
                return view('admin.tables.table-usg', ['setor' => $setor]);
                #dd($setor);
                break;

            case 2:
                $query = DB::table('faturas')
                    ->whereIn('faturas.setor', ['TOMOGRAFIA', 'RESSONANCIA'])
                    ->whereBetween('data_req', [$data_inicio, $data_final]);

                if ($nota == 1) {
                    $query->where('ratings.finalizado', 1)
                        ->where(function ($query) {
                            $query->where('ratings.nota_clinica', '>', 3)
                                ->orWhere('ratings.recep_rate', '>', 3)
                                ->orWhere('ratings.atend_rate', '>', 3)
                                ->orWhere('faturas.livro_rate', '>', 3)
                                ->orWhere('faturas.enf_rate', '>', 3);
                        });
                } elseif ($nota == 2) {
                    $query->where('ratings.finalizado', 1)
                        ->where(function ($query) {
                            $query->where('ratings.nota_clinica', '<', 4)
                                ->orWhere('ratings.recep_rate', '<', 4)
                                ->orWhere('ratings.atend_rate', '<', 4)
                                ->orWhere('faturas.livro_rate', '<', 4)
                                ->orWhere('faturas.enf_rate', '<', 4);
                        });
                };

                $setor = $query->join('ratings', 'ratings.id', '=', 'faturas.rating_id')
                    ->orderBy($ordem)
                    ->get();
                return view('admin.tables.table-rm', ['setor' => $setor]);
                #dd($setor);
                break;

            case 3:
                $query = DB::table('faturas')
                    ->whereIn('faturas.setor', ['DENSITOMETRIA', 'MAMOGRAFIA', 'RAIOS X', 'MAPA', 'ELETROCARDIOGRAMA'])
                    ->whereBetween('data_req', [$data_inicio, $data_final]);

                if ($nota == 1) {
                    $query->where('ratings.finalizado', 1)
                        ->where(function ($query) {
                            $query->where('ratings.nota_clinica', '>', 3)
                                ->orWhere('ratings.recep_rate', '>', 3)
                                ->orWhere('ratings.atend_rate', '>', 3)
                                ->orWhere('faturas.livro_rate', '>', 3);
                        });
                } elseif ($nota == 2) {
                    $query->where('ratings.finalizado', 1)
                        ->where(function ($query) {
                            $query->where('ratings.nota_clinica', '<', 4)
                                ->orWhere('ratings.recep_rate', '<', 4)
                                ->orWhere('ratings.atend_rate', '<', 4)
                                ->orWhere('faturas.livro_rate', '<', 4);
                        });
                };

                $setor = $query->join('ratings', 'ratings.id', '=', 'faturas.rating_id')
                    ->orderBy($ordem)
                    ->get();
                return view('admin.tables.table-radiologia', ['setor' => $setor]);
                #dd($setor);
                break;

            default:
                $query = DB::table('faturas')
                    ->whereBetween('data_req', [$data_inicio, $data_final]);

                if ($nota == 1) {
                    $query->where('ratings.finalizado', 1)
                        ->where(function ($query) {
                            $query->where('ratings.nota_clinica', '>', 3)
                                ->orWhere('ratings.recep_rate', '>', 3)
                                ->orWhere('ratings.atend_rate', '>', 3)
                                ->orWhere('faturas.livro_rate', '>', 3);
                        });
                } elseif ($nota == 2) {
                    $query->where('ratings.finalizado', 1)
                        ->where(function ($query) {
                            $query->where('ratings.nota_clinica', '<', 4)
                                ->orWhere('ratings.recep_rate', '<', 4)
                                ->orWhere('ratings.atend_rate', '<', 4)
                                ->orWhere('faturas.livro_rate', '<', 4);
                        });
                };

                $setor = $query->join('ratings', 'ratings.id', '=', 'faturas.rating_id')
                    ->orderBy($ordem)
                    ->get();
                return view('admin.tables.table-setores', ['setor' => $setor]);
                #dd($setor);
                break;
        }
    }
}
