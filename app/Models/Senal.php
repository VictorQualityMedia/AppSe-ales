<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Senal extends Model
{
    use HasFactory;

    protected $table = 'senales';

    /**
     * Los atributos que son asignables.
     */
    protected $fillable = [
        'cliente',
        'envios',
        'dia',
        'hora',
    ];
}