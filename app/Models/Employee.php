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


}
