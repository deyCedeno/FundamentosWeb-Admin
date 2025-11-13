<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categoria';
    protected $primaryKey = 'idCategoria';
    
    protected $fillable = [
        'nombre',
        'urlImagen'
    ];

    public function comercios()
    {
        return $this->belongsToMany(Comercio::class, 'comercio_categoria', 'idCategoria', 'idComercio');
    }

    public function comerciosCount()
    {
        return $this->comercios()->count();
    }
}