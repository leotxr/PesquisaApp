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
        $dataForm = $request->all();

        $rating_id = $dataForm['rating_id'];


        for ($i = 0; $i < count($request->rating_id); $i++) {
            DB::table('faturas')->updateOrInsert([
                #'fatura_id' => $request->fatura_id[$i],
                'rating_id' => $request->rating_id[$i],
                'fatura_data' => $request->data_fatura[$i],
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
        }
        DB::table('ratings')
            ->where('id', $rating_id)
            ->update(['recomenda' => $request->rec_rate]);

        #dd($request);
        return view('rate-ultri', ['rating_id' => $rating_id]);
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

        switch ($setores) {
            case 1:
                $setor = DB::table('faturas')
                    ->where('faturas.setor', '=', 'ULTRA-SON')
                    ->orWhere('faturas.setor', '=', 'CARDIOLOGIA')
                    ->whereBetween('data_req', [$data_inicio, $data_final])
                    ->join('ratings', 'ratings.id', '=', 'faturas.rating_id')
                    ->orderBy($ordem)
                    ->get();
                return view('admin.tables.table-usg', ['setor' => $setor]);
                break;

            case 2:
                $setor = DB::table('faturas')
                    ->where('faturas.setor', '=', 'TOMOGRAFIA')
                    ->orWhere('faturas.setor', '=', 'RESSONANCIA')
                    ->whereBetween('data_req', [$data_inicio, $data_final])
                    ->join('ratings', 'ratings.id', '=', 'faturas.rating_id')
                    ->orderBy($ordem)
                    ->get();
                return view('admin.tables.table-rm', ['setor' => $setor]);
                break;

            case 3:
                $setor = DB::table('faturas')
                    ->whereIn('faturas.setor', ['DENSITOMETRIA', 'MAMOGRAFIA', 'RAIOS X', 'MAPA', 'ELETROCARDIOGRAMA'])
                    ->whereBetween('data_req', [$data_inicio, $data_final])
                    ->join('ratings', 'ratings.id', '=', 'faturas.rating_id')
                    ->orderBy($ordem)
                    ->get();
                return view('admin.tables.table-radiologia', ['setor' => $setor]);
                break;

            default:
                $setor = DB::table('faturas')
                    ->whereBetween('data_req', [$data_inicio, $data_final])
                    ->join('ratings', 'ratings.id', '=', 'faturas.rating_id')
                    ->orderBy($ordem)
                    ->get();
                return view('admin.tables.table-setores', ['setor' => $setor]);
        }
    }
}
