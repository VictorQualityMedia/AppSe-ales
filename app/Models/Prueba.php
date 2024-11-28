<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    use HasFactory;

    protected $table = 'pruebas';

    /**
     * Los atributos que son asignables.
     */
    protected $fillable = [
        'cliente',
        'punto',
        'dia',
        'hora',
        'resultado',
    ];
}