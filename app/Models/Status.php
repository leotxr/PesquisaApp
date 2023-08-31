<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'icon'
    ];

    public function statusComentario()
    {
        return $this->hasMany(Rating::class);
    }
    

}
