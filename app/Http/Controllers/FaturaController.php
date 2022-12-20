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

        $req_id = $dataForm['req_id'];

/*
        $table = new Fatura;    // Setando as propriedades
        for ($i = 0; $i < count($request->req_id); $i++) {
            $table->req_id = $request->req_id[$i];
            $table->med_name = $request->medico_name[$i];
            $table->med_rate = $request->med_rate[$i];
            $table->tec_name = $request->tecnico_name[$i];
            if (isset($request->us_name[$i])) {
                $table->us_name = $request->us_name[$i];
                $table->us_rate = $request->us_rate[$i];
            }
            if (isset($request->enf_name[$i])) {
                $table->enf_name = $request->enf_name[$i];
                $table->enf_rate = $request->enf_rate[$i];
            }

            $table->setor = $request->setor[$i];    // Inserindo os dados no DB

            $table->save();
        }
*/

        for ($i = 0; $i < count($request->req_id); $i++) {
            DB::table('faturas')->updateOrInsert([
                #'fatura_id' => $request->fatura_id[$i],
                'req_id' => $request->req_id[$i],
                'fatura_data' => $request->data_fatura[$i],
                'med_name' => $request->medico_name[$i]??NULL,
                'med_rate' => $request->med_rate[$i]??NULL,
                'tec_name' => $request->tecnico_name[$i]??NULL,
                'us_name' => $request->us_name[$i]??NULL,
                'us_rate' => $request->us_rate[$i]??NULL,
                'enf_name' => $request->enf_name[$i]??NULL,
                'enf_rate' => $request->enf_rate[$i]??NULL,
                'setor' => $request->setor[$i]??NULL

            ]);
        }

        #dd($request);
        return view('rate-ultri', ['req_id' => $req_id]);
    }


    public function relatorioUSG(Request $request)
    {
        $dataForm = $request->all();
        $data_inicio = $request->data_inicio;
        $data_final = $request->data_final;
        $med_name = $dataForm['med_name'];
        $ordem = $dataForm['ordem'];

        $sql = "select RA.data_req as DATA, RA.pac_name AS PACIENTE, ";
        $sql = $sql . "FA.med_name AS MEDICO, FA.med_rate AS NOTA_MEDICO, FA.setor AS SETOR, RA.nota_clinica AS ULTRIMAGEM ";
        $sql = $sql . "FROM faturas as FA INNER JOIN ratings as RA on RA.id = FA.req_id ";
        $sql = $sql . "WHERE FA.med_name LIKE('$med_name') and RA.data_req BETWEEN '$data_inicio' and '$data_final' ORDER BY $ordem";
        $relusg = DB::connection('mysql')->select($sql);
        return view('admin.tables.table-usg', ['relusg' => $relusg]);
    }
}
