<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComercioImagen extends Model
{
    use HasFactory;

    protected $table = 'comercio_imagen';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'idComercio',
        'urlImagen'
    ];

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'idComercio');
    }
}