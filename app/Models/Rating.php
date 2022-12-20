<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table='ratings';
    protected $fillable=['req_id',
    'tipo_agendamento',
    'data_req',
    'pac_name',
    'pac_id',
    'atend_name',
    'atend_rate',
    'recep_name',
    'recep_rate',
    'nota_clinica'
];
    use HasFactory;

    public function relFaturas()
    {
        return $this->hasMany(Fatura::class, 'req_id');
    }

    
}
