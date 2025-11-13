<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'enlace',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];
}