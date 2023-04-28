<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table='ratings';
    protected $fillable=[
    'requisicao_id',
    'grp_agendamento',
    'tipo_atraso',
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
    'class_comentario',
    'status_comentario_id',
    'created_at',
    'updated_at',
];
    use HasFactory;

    public function relFaturas()
    {
        return $this->hasMany(Fatura::class);
    }

    public function relStatus()
    {
        return $this->hasOne('App\Models\Rating', 'status_comentario_id', 'id');
    }


}
