<?php

namespace App\Http\Livewire\Settings\Employees;

use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class EditEmployee extends Component
{
    use WithFileUploads;

    public Employee $employee;
    public $roles; //todos os cargos
    public $role; //cargo selecionado

    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $x_clinic_id;
    #[Validate('max:200')]
    public $description_name;

    #[Validate('max:4096')]
    public $photo;
    public $modalEdit = false;

    protected $listeners = [
      'editEmployee' => 'editEmployee'
    ];

    protected $rules = [
            'employee.name' => 'required',
            'employee.description_name' => 'max:100',
            'employee.x_clinic_id' => 'required'
    ];

    public function mount()
    {
        $this->roles = Role::all();

    }
    public function editEmployee(Employee $employee)
    {
        $this->employee = $employee;
        $this->name = $this->employee->name;
        $this->x_clinic_id = $this->employee->x_clinic_id;
        $this->description_name = $this->employee->description_name;
        $this->modalEdit = true;


    }

    public function update()
    {
        $this->validate();
        $this->employee->name = $this->name;
        $this->employee->x_clinic_id = $this->x_clinic_id;
        $this->employee->description_name = $this->description_name;

        if($this->photo)
        {
            $path = $this->photo->storePublicly("storage/fotos_funcionarios", 'my_files');
            $this->employee->photo = $path;
        }


        $this->employee->save();
        $this->modalEdit = false;
        $this->dispatch('refreshParent');
        $this->reset('photo');
    }

    public function attachRole()
    {
        $this->employee->assignRole($this->role);
        $this->employee->save();
    }

    public function detachRole($role)
    {
        $this->employee->removeRole($role);
        $this->employee->save();
    }

    public function delete()
    {
       $delete = $this->employee->delete();
        if($delete)
        {
            $this->modalEdit = false;
            $this->dispatch('refreshParent');
        }

    }

    public function render()
    {
        return view('livewire.settings.employees.edit-employee');
    }
}
