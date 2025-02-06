<?php

namespace App\Traits;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

trait XClinicTraits
{
    #   Trait com funções de busca no banco de dados do X-Clinic.


    /**
     * @throws \Exception
     */

    #   Função para buscar as requisições (exames) realizados pelo paciente na data atual.
    #   Parâmetros:
    #   $paciente_id: Código do paciente no X-Clinic. Digitado pelo mesmo no início da pesquisa.
    #   Validações: Valida se o código informado é um código numérico, caso não seja, dispara uma exception com uma mensagem de erro;
    #   Retorno: Retorna um array com os exames realizados pelo paciente contendo as informações sobre o atendimento.
    #   Se o paciente não tiver realizado um exame na data de hoje, o sistema não vai encontrar exames e vai disparar uma exception com uma mensagem de erro.

    public function getRequests($paciente_id): array
    {
        if (is_numeric($paciente_id)) { //Testa se o código informado é um numero inteiro
            $request = DB::connection('sqlsrv')->table('WORK_LIST')
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
                ->leftJoin('USUARIOS', 'USUARIOS.USERID', '=', 'FATURA.USUARIO')
                ->leftJoin('MEDICOS', 'MEDICOS.MEDICOID', '=', 'FATURA.TECNICOID')
                ->leftJoin('WORK_FILAS', 'WORK_FILAS.FILAID', '=', 'WORK_LIST.FILAID')
                ->where('WORK_LIST.PACIENTEID', '=', $paciente_id)
                ->whereDate('FATURA.DATA', '=', date('Y/m/d'))
                ->select(DB::raw("DISTINCT FORMAT(FATURA.DATA, 'yyyy/MM/dd') AS DATA, 
                WORK_LIST.REQUISICAOID AS REQUISICAO, 
                WORK_LIST.STATUSID, 
                FATURA.PACIENTEID AS PACIENTEID, 
                PACIENTE.NOME AS PACIENTE, 
                PROCEDIMENTOS.DESCRICAO AS PROCEDIMENTO, 
                SETORES.DESCRICAO AS SETOR,
                MEDICOS.NOME_SOCIAL AS TECNICO, 
                MEDICOS.USERID AS MED_ID, 
                WORK_FILAS.FILANOME AS MEDICO, 
                USUARIOS.NOME_SOCIAL AS RECEPCIONISTA, 
                USUARIOS.USERID AS RECEP_ID, 
                FATURA.REQUISICAOID, 
                FATURA.FATURAID AS FATURA"))
                ->get()->toArray();

            if (!$request) throw new \Exception('Código não encontrado! Verifique seu protocolo e tente novamente.'); // Se não encontrar exames dispara exception.
            else return $request; // Se encontrar exames, retorna o array com os exames
        } else
            throw new \Exception('Código não encontrado! Verifique seu protocolo e tente novamente.'); //Se não for numérico, retorna exception.

    }

    public function getAgenda($data, $paciente_id)
    {
        $sqlsrv = "Select TOP 1 A.PACIENTEID, FORMAT(A.DATA, 'yyyy/MM/dd') AS DATA, A.NOMEPAC AS PACIENTE, A.USERNAME AS ATENDENTE, A.USUARIO AS USERID, A.NOME_EXAME AS PROCEDIMENTO FROM VW_AGENDA AS A ";
        $sqlsrv = $sqlsrv . "WHERE A.DATA = '$data' AND ";
        $sqlsrv = $sqlsrv . "A.PACIENTEID = '$paciente_id' AND ";
        $sqlsrv = $sqlsrv . "A.USERNAME IS NOT NULL";
        $agendas = DB::connection('sqlsrv')->select($sqlsrv);
        return $agendas;
    }

    /**
     * @throws \Exception
     */

    #   Função para buscar as enfermeiras que realizaram a triagem do paciente.
    #   Parâmetros:
    #   $requisicao_id: Numero da requisição recuperado na função anterior. O número da requisição é o número do atendimento no X-clinic, contem os exames;
    #   $fatura_id: Código de cada exame realizado pelo paciente.
    #   Validações: A triagem no X-Clinic deve ter um arquivo anexado, se não houver dispara uma exception com mensagem de erro.
    #   Retorno: Retorna o primeiro registro contendo o nome e código da enfermeira que fez a triagem do exame.
    public function getNurses($requisicao_id, $fatura_id)
    {
        $nurses = DB::connection('sqlsrv')->table('RASOCORRENCIAS')
            ->join('WORK_LIST', function ($join_paciente) {
                $join_paciente->on('WORK_LIST.PACIENTEID', '=', 'RASOCORRENCIAS.PACIENTEID')
                    ->on('WORK_LIST.DATA', '=', 'RASOCORRENCIAS.DATA');
            })
            ->join('USUARIOS', 'USUARIOS.USERID', '=', 'RASOCORRENCIAS.USERID')
            ->where('RASOCORRENCIAS.RASEVENTOID', '=', 250003) //Código de evento do X-Clinic onde aparece a enfermeira que adicionou um arquivo na triagem.
            ->where('WORK_LIST.REQUISICAOID', '=', $requisicao_id) //Numero da requisição retornada na função inicial.
            ->where('WORK_LIST.FATURAID', '=', $fatura_id)//Código do exame realizado.
            ->select(DB::raw("TOP 1 USUARIOS.NOME_SOCIAL AS ENFERMEIRA, USUARIOS.USERID AS ENF_ID"))
            ->get();

        if ($nurses) return $nurses; //Se a busca for realizada corretamente, retorna o objeto.
        else throw new \Exception('Ocorreu um erro ao buscar os dados da triagem. Verifique se foi finalizada corretamente ou entre em contato com o setor de TI.');
    }

    /**
     * @throws \Exception
     */

    #   Função para atualizar as enfermeiras da pesquisa caso ela ja tenha sido realizada anteriormente.
    #   Parâmetros:
    #   $invoice: Código do exame(Fatura) dentro do banco da Pesquisa de satisfação;
    #   $nurse_id: Código da enfermeira cadastrado no X-Clinic.
    #   $doctor_id: Código do técnico cadastrado no X-Clinic.
    #   Validações: Caso a enfermeira ou técnico de radiologia não esteja cadastrado corretamente no sistema de pesquisa dispara uma exception com erro.
    #   Correção: Verificar se a Enfermeira ou tecnico estão cadastrados no sistema de pesquisa,
    #   se o usuário está configurado com o setor correto
    #   e X-Clinic-ID está correto no painel sistema de Pesquisa de satisfação.
    public function updateNurses($invoice, $nurse_id, $doctor_id)
    {
        $enf = Employee::where('x_clinic_id', $nurse_id)->first();
        $tec = Employee::where('x_clinic_id', $doctor_id)->first();


        if ($enf && $tec) {
            $invoice->employees()->detach([$tec->id]);
            $invoice->employees()->detach([$enf->id]);
            $invoice->employees()->attach([$tec->id => ['role' => 'tec']]);
            $invoice->employees()->attach([$enf->id => ['role' => 'enf']]);
            return true;
        } else {
            throw new \Exception('Enfermeira(o) e/ou Técnica(o) não encontrada(o). Contate o setor de TI.');
        }

    }

    /**
     * @throws \Exception
     */
    public function getUSG($requisicao_id, $fatura_id)
    {
        $usg = DB::connection('sqlsrv')->table('RASOCORRENCIAS')
            ->join('FATURA', function ($join_fatura) {
                $join_fatura //->on('RASOCORRENCIAS.PACIENTEID', '=', 'FATURA.PACIENTEID')
                //->on('RASOCORRENCIAS.UNIDADEID', '=', 'FATURA.UNIDADEID')
                ->on('RASOCORRENCIAS.FATURAID', '=', 'FATURA.FATURAID');
            })
            ->join('USUARIOS', 'RASOCORRENCIAS.USERID', '=', 'USUARIOS.USERID')
            ->join('SETORES', 'SETORES.SETORID', '=', 'FATURA.SETORID')
            ->whereIn('RASOCORRENCIAS.RASEVENTOID', [38])
            ->whereIn('SETORES.DESCRICAO', ['ULTRA-SON', 'CARDIOLOGIA', 'ANGIOLOGIA'])
            ->where('FATURA.REQUISICAOID', $requisicao_id)
            ->where('FATURA.FATURAID', $fatura_id)
            ->selectRaw('RASOCORRENCIAS.DATA AS DATA, FATURA.REQUISICAOID, SETORES.DESCRICAO, USUARIOS.NOME_SOCIAL AS USUARIO, USUARIOS.USERID AS USG_ID, FATURA.FATURAID')
            ->get()
            ->first();
        if ($usg) return $usg;
        else throw new \Exception('Ocorreu um erro ao buscar os dados do Ultra-son. Verifique se foi finalizada corretamente ou entre em contato com o setor de TI.');
    }

    public function compareServiceUSG($sectors, $start_date, $end_date, $employee)
    {
        return DB::connection('sqlsrv')->table('RASOCORRENCIAS')
            ->join('FATURA', function ($join_fatura) {
                $join_fatura->on('RASOCORRENCIAS.PACIENTEID', '=', 'FATURA.PACIENTEID')
                    ->on('RASOCORRENCIAS.UNIDADEID', '=', 'FATURA.UNIDADEID')
                    ->on('RASOCORRENCIAS.FATURAID', '=', 'FATURA.FATURAID');
            })
            ->join('USUARIOS', 'RASOCORRENCIAS.USERID', '=', 'USUARIOS.USERID')
            //->join('SETORES', 'SETORES.SETORID', '=', 'FATURA.SETORID')
            ->whereIn('RASOCORRENCIAS.RASEVENTOID', [38])
            ->whereIn('FATURA.SETORID', $sectors)
            ->whereBetween('RASOCORRENCIAS.DATA', [$start_date, $end_date])
            ->where('USUARIOS.USERID', $employee)
            ->select(DB::raw('COUNT(DISTINCT CONCAT(FATURA.DATA, FATURA.PACIENTEID, FATURA.SETORID, USUARIOS.USERID, RASOCORRENCIAS.UNIDADEID)) AS TOTAL'))->get();
        //->distinct('FATURA.REQUISICAOID')->get();
    }

    public function compareServiceRec($start_date, $end_date, $employee)
    {
        return DB::connection('sqlsrv')->table('TOTEM_FILAS_ESPERA')
            ->join('USUARIOS', 'USUARIOS.USERID', '=', 'TOTEM_FILAS_ESPERA.CHAMADO')
            ->join('TOTEM_CONFIGURACOES', 'TOTEM_CONFIGURACOES.TOTEMID', '=', 'TOTEM_FILAS_ESPERA.TOTEMID')
            ->leftJoin('PACIENTE', 'PACIENTE.PACIENTEID', '=', 'TOTEM_FILAS_ESPERA.PACIENTEID')
            ->whereBetween('TOTEM_FILAS_ESPERA.DATA', [$start_date, $end_date])
            ->where('TOTEM_FILAS_ESPERA.CHAMADO', $employee)
            ->whereNotNull('PACIENTE.NOME')
            ->select(DB::raw('COUNT(DISTINCT CONCAT(TOTEM_FILAS_ESPERA.DATA, TOTEM_FILAS_ESPERA.PACIENTEID, PACIENTE.NOME, USUARIOS.NOME_SOCIAL)) AS TOTAL'))->get();
    }

    public function compareServiceTech($sectors, $start_date, $end_date, $employee)
    {
        return DB::connection('sqlsrv')->table('WORK_LIST')
            ->leftJoin('FATURA', function ($join_fatura) {
                $join_fatura->on('FATURA.FATURAID', '=', 'WORK_LIST.FATURAID')
                    ->on('FATURA.UNIDADEID', '=', 'WORK_LIST.UNIDADEID')
                    ->on('FATURA.PACIENTEID', '=', 'WORK_LIST.PACIENTEID')
                    ->on('FATURA.REQUISICAOID', '=', 'WORK_LIST.REQUISICAOID');
            })
            ->leftJoin('WORK_FILAS', 'WORK_FILAS.FILAID', '=', 'WORK_LIST.FILAID')
            ->leftJoin('MEDICOS', 'MEDICOS.MEDICOID', '=', 'FATURA.TECNICOID')
            ->whereIn('FATURA.SETORID', $sectors)
            ->whereBetween('WORK_LIST.DATA', [$start_date, $end_date])
            ->where('MEDICOS.USERID', $employee)
            ->select(DB::raw('COUNT(DISTINCT CONCAT(WORK_LIST.DATAEXAME, FATURA.PACIENTEID, FATURA.SETORID, WORK_FILAS.FILANOME, MEDICOS.USERID, FATURA.UNIDADEID)) AS TOTAL'))->get();
    }

    public function compareServiceNurse($sectors, $start_date, $end_date, $employee)
    {
        return DB::connection('sqlsrv')->table('RASOCORRENCIAS')
            ->join('WORK_LIST', function ($join_paciente) {
                $join_paciente->on('WORK_LIST.PACIENTEID', '=', 'RASOCORRENCIAS.PACIENTEID')
                    ->on('WORK_LIST.DATA', '=', 'RASOCORRENCIAS.DATA');
            })
            ->join('FATURA', 'FATURA.FATURAID', '=', 'WORK_LIST.FATURAID')
            ->join('USUARIOS', 'USUARIOS.USERID', '=', 'RASOCORRENCIAS.USERID')
            ->where('RASOCORRENCIAS.RASEVENTOID', '=', 250003)
            ->whereIn('FATURA.SETORID', $sectors)
            ->whereBetween('WORK_LIST.DATA', [$start_date, $end_date])
            ->where('USUARIOS.USERID', $employee)
            ->select(DB::raw("COUNT(DISTINCT CONCAT(USUARIOS.USERID, WORK_LIST.DATA, WORK_LIST.PACIENTEID, FATURA.SETORID)) AS TOTAL"))
            ->get();
    }

    public function compareServiceRecAgd($data)
    {
        $dataInicio = $data['dataInicio'];
        $dataFim = $data['dataFim'];
        $userId = $data['xClinicId'];

        $sqlsrv = "SELECT COUNT(A.USUARIO) 
        FROM VW_AGENDA AS A ";
        $sqlsrv = $sqlsrv . "WHERE A.DATA BETWEEN '$dataInicio' AND '$dataFim' AND";
        $sqlsrv = $sqlsrv . "A.USUARIO = '$userId' AND ";
        $sqlsrv = $sqlsrv . "A.USERNAME IS NOT NULL";
        $agendas = DB::connection('sqlsrv')->select($sqlsrv);
        return $agendas;
    }

    public function updateRecep($rating, $recep_id, $atend_id)
    {
        $recep = Employee::where('x_clinic_id', $recep_id)->first();
        $atend = Employee::where('x_clinic_id', $atend_id)->first();


        if ($recep && $atend) {
            $rating->employees()->detach([$recep->id]);
            $rating->employees()->detach([$atend->id]);
            $rating->employees()->attach([$recep->id => ['role' => 'rec']]);
            $rating->employees()->attach([$atend->id => ['role' => 'agd']]);
            return true;
        } else {
            throw new \Exception('Atendente nao encontrado. Contate o setor de TI.');
        }
    }
}
