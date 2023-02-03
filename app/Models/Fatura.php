<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $table='faturas';
    protected $fillable=[
    'rating_id',
    'requisicao_id',
    'fatura_id',
    'fatura_data',
    'livro_name',
    'livro_rate',
    'tec_name',
    'tec_rate',
    'us_name',
    'us_rate',
    'enf_name',
    'enf_rate',
    'setor'
];
    use HasFactory;

    public function relRatings()
    {
        return $this->belongsTo(Rating::class);
    }
}
