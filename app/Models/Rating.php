<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table='ratings';
    protected $fillable=[
    'grp_agendamento',
    'data_req',
    'pac_name',
    'pac_id',
    'atend_name',
    'atend_rate',
    'recep_name',
    'recep_rate',
    'nota_clinica',
    'comentario',
    'finalizado',
    'created_at',
    'updated_at'
];
    use HasFactory;

    public function relFaturas()
    {
        return $this->hasMany(Fatura::class);
    }


}
