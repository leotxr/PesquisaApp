<?php

namespace App\Http\Livewire\Settings\Employees;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ShowEmployees extends Component
{
    use WithPagination;

    public $confirmSync = false;

    protected $listeners = [
        'refreshParent' => '$refresh'
    ];

    public function synchronize()
    {
        $xclinic_users = DB::connection('sqlsrv')
            ->table('USUARIOS')
            ->whereIn('GRUPOID', [7, 13, 14, 45, 48, 49, 50, 53, 55 ])
            ->selectRaw('USERID, NOME')
            ->get();

        foreach ($xclinic_users as $user) {

            Employee::updateOrCreate(
                ['name' => $user->NOME,
                    'x_clinic_id' => $user->USERID],

            );
        }

        $this->confirmSync = false;
        $this->render();
    }

    public function render()
    {
        return view('livewire.settings.employees.show-employees', ['employees' => Employee::orderBy('name', 'asc')->paginate(10)]);
    }
}
