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

    public function getRelatorioFuncionarios(Request $request)
    {
        $data = $request;
        $this->start_date = $request;
        $this->end_date = $data->dataFim;

        var_dump($request);exit;

        foreach (Employee::role('recepcionista')->get() as $employee)
        {
            $this->receptionists[] = (object)['name' => $employee->name,
                'count' => $employee->ratings->whereBetween('data_req', [$this->start_date, $this->end_date])->where('role', 'rec')->count(),
                'x_clinic_count' => $this->compareServiceRec($this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL];
            $this->rec_agendamento[] = (object)['name'=> $employee->name,
            'count'=> 1,
            'x_clinic_count' => 1];
        }

        foreach (Employee::role('tecnico')->get() as $employee)
            $this->technicians[] = (object)['name' => $employee->name,
                'count' => $employee->faturas()->whereBetween('fatura_data', [$this->start_date, $this->end_date])->where('role', 'tec')->count(),
                'x_clinic_count' => $this->compareServiceTech([1, 2, 3, 4, 9, 13, 18, 20, 21], $this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL
            ];

        foreach (Employee::role('recepcionista usg')->get() as $employee)
            $this->usg_receptionists[] = (object)['name' => $employee->name,
                'count' => $employee->faturas->whereBetween('fatura_data', [$this->start_date, $this->end_date])->count(),
                'x_clinic_count' => $this->compareServiceUSG([5, 10, 22], $this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL];

        foreach (Employee::role('enfermeira')->get() as $employee)
            $this->nurses[] = (object)['name' => $employee->name,
                'count' => $employee->faturas()->whereBetween('fatura_data', [$this->start_date, $this->end_date])->where('role', 'enf')->count(),
                'x_clinic_count' => $this->compareServiceNurse([4, 9], $this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL];

        return $data;
    }
}