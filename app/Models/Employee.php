<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guard_name = 'web';
    protected $fillable = [
        'name',
        'description_name',
        'x_clinic_id',
        'role',
        'photo'
    ];

    public function faturas()
    {
        return $this->belongsToMany(Fatura::class)->withPivot('role', 'rate');;
    }

    public function ratings()
    {
        return $this->belongsToMany(Rating::class)->withPivot('role', 'rate');;
    }

    public function getAgendamentos($data)
    {
        $role = $data['role'];
        $roleId = $data['role_id'];
        $dataInicio = $data['data_inicial'];
        $dataFim = $data['data_final'];
    
        $results = EmployeeRating::select('er.rate', 'em.name', 'er.role', 'ra.data_req', 'ra.pac_name')
            ->join('ratings as ra', 'ra.id', '=', 'er.rating_id')
            ->join('employees as em', 'em.id', '=', 'er.employee_id')
            ->join('model_has_roles as mhr', 'mhr.model_id', '=', 'em.id')
            ->where('er.role', $role)
            ->whereBetween('ra.data_req', [$dataInicio, $dataFim])
            ->where('mhr.role_id', $roleId)
            ->get();
    
        return $results;
    }

}
