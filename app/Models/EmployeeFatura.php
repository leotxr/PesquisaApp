<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'fatura_id',
        'employee_id',
        'rate',
        'role'
    ];
}
