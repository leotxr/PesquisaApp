<?php

namespace App\Http\Livewire\Reports;

use App\Models\Employee;
use App\Traits\XClinicTraits;
use Illuminate\Support\Collection;
use Livewire\Component;

class EmployeeReport extends Component
{

    use XClinicTraits;

    public $technicians = [];
    public $receptionists = [];
    public $usg_receptionists = [];
    public $nurses = [];
    public $start_date;
    public $end_date;
    public $agd_receptionists = [];

    public function mount()
    {
        // $recepcionistas = Employee::role('recepcionista')->get();
        // $tecnicos = Employee::role('tecnico')->get();
        // $enfermeiras = Employee::role('enfermeira')->get();

        //dd($this->compareServiceNurse([4,9], '2024-01-30', '2024-01-30', 79)[0]->TOTAL);
        //dd($this->compareServiceRec( '2024-01-01', '2024-01-24', 8)[0]->TOTAL);


    }

    public function search()
    {
        $this->reset('receptionists', 'technicians', 'usg_receptionists', 'nurses', 'agd_receptionists');
        foreach (Employee::role('recepcionista')->get() as $employee)
            $this->receptionists[] = (object)[
                'name' => $employee->name,
                'count' => $employee->ratings()->whereBetween('data_req', [$this->start_date, $this->end_date])->where('role', 'rec')->count(),
                'x_clinic_count' => $this->compareServiceRec($this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL
            ];

        foreach (Employee::role('tecnico')->get() as $employee)
            $this->technicians[] = (object)[
                'name' => $employee->name,
                'count' => $employee->faturas()->whereBetween('fatura_data', [$this->start_date, $this->end_date])->where('role', 'tec')->count(),
                'x_clinic_count' => $this->compareServiceTech([1, 2, 3, 4, 9, 13, 18, 20, 21], $this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL
            ];

        foreach (Employee::role('recepcionista usg')->get() as $employee)
            $this->usg_receptionists[] = (object)[
                'name' => $employee->name,
                'count' => $employee->faturas->whereBetween('fatura_data', [$this->start_date, $this->end_date])->count(),
                'x_clinic_count' => $this->compareServiceUSG([5, 10], $this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL
            ];

        foreach (Employee::role('enfermeira')->get() as $employee)
            $this->nurses[] = (object)[
                'name' => $employee->name,
                'count' => $employee->faturas()->whereBetween('fatura_data', [$this->start_date, $this->end_date])->where('role', 'enf')->count(),
                'x_clinic_count' => $this->compareServiceNurse([4, 9], $this->start_date, $this->end_date, $employee->x_clinic_id)[0]->TOTAL
            ];

        foreach (Employee::role('recepcionista')->get() as $employee)
        {
            $dados = [
                'dataInicio' => $this->start_date,
                'dataFim' => $this->end_date,
                'xClinicId' => $employee->x_clinic_id
            ];

            $this->agd_receptionists[] = (object)[
                'name' => $employee->name,
                'count' => $employee->ratings()->whereBetween('data_req', [$this->start_date, $this->end_date])->where('role', 'agd')->count(),
                'x_clinic_count' => $this->compareServiceRecAgd($dados)
            ];
        }


        $this->render();
    }

    public function render()
    {
        return view('livewire.reports.employee-report');
    }
}
