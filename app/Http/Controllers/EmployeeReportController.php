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

        return $data;
    }
}