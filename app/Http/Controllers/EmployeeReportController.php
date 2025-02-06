<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Traits\XClinicTraits;
use Illuminate\Support\Collection;

class EmployeeReportController extends Controller
{
    use XClinicTraits;

    public $technicians = [];
    public $receptionists = [];
    public $rec_agendamento = [];
    public $usg_receptionists = [];
    public $nurses = [];
    public $start_date;
    public $end_date;
    public $EmpModel;

    public function __construct()
    {
        $this->EmpModel = new Employee();
    }
/*
    private function getAgendamentosRecep($role, $role_id)
    {
        $data = array(
            'data_inicial' => $this->start_date,
            'data_final' => $this->end_date,
            'role' => $role,
            'role_id' => $role_id
        );

        $this->EmpModel->getAgendamentos($data);
    }
*/
    private function calcularAtendimento($v1, $v2)
    {
        $count = $v1;
        $xClinic = $v2;

        if($count > 0 && $xClinic > 0)
        $avg = number_format($count / $xClinic * 100, 2, '.', '');
        else $avg = 0;

        return $avg;
    }

    public function getRelatorioFuncionarios(Request $request)
    {
        $data = $request;
        $this->start_date = $request->dataInicio;
        $this->end_date = $data->dataFim;
        $retorno = [];

        foreach (Employee::role('recepcionista')->get() as $employee)
        {
            $count = $employee->ratings->whereBetween('data_req', [$this->start_date, $this->end_date])->where('role', 'rec')->count();
            $xClinic = $this->compareServiceRec($this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL;
            $avg = $this->calcularAtendimento($count, $xClinic);
            
            $this->receptionists[] = (object)['name' => $employee->name,
                'count' => $count,
                'x_clinic_count' => $xClinic,
                'avg' => $avg];

            $this->rec_agendamento[] = (object)['name'=> $employee->name,
            'count' => 1,
            'x_clinic_count' => 1,
            'avg' => 1];
        }

        foreach (Employee::role('tecnico')->get() as $employee)
        {
            $count = $employee->faturas()->whereBetween('fatura_data', [$this->start_date, $this->end_date])->where('role', 'tec')->count();
            $xClinic = $this->compareServiceTech([1, 2, 3, 4, 9, 13, 18, 20, 21], $this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL;
            $avg = $this->calcularAtendimento($count, $xClinic);

            $this->technicians[] = (object)['name' => $employee->name,
                'count' => $count,
                'x_clinic_count' => $xClinic,
                'avg' => $avg
            ];
        }

        foreach (Employee::role('recepcionista usg')->get() as $employee)
        {
            $count = $employee->faturas->whereBetween('fatura_data', [$this->start_date, $this->end_date])->count();
            $xClinic = $this->compareServiceUSG([5, 10, 22], $this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL;
            $avg = $this->calcularAtendimento($count, $xClinic);

            $this->usg_receptionists[] = (object)['name' => $employee->name,
                'count' => $count,
                'x_clinic_count' => $xClinic,
                'avg' => $avg];
        }

        foreach (Employee::role('enfermeira')->get() as $employee)
        {
            $count = $employee->faturas()->whereBetween('fatura_data', [$this->start_date, $this->end_date])->where('role', 'enf')->count();
            $xClinic = $this->compareServiceNurse([4, 9], $this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL;
            $avg = $this->calcularAtendimento($count, $xClinic);
            $this->nurses[] = (object)['name' => $employee->name,
                'count' => $count,
                'x_clinic_count' => $xClinic,
                'avg' => $avg];
        }

        $retorno['recepcionistas'] = $this->receptionists;
        $retorno['recep_agendamento'] = $this->rec_agendamento;
        $retorno['tecnicos'] = $this->technicians;
        $retorno['usg'] = $this->usg_receptionists;
        $retorno['enfermeiras'] = $this->nurses;
        
        return json_encode($retorno);

    }
}