<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoImagen extends Model
{
    use HasFactory;

    protected $table = 'producto_imagen';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'idProducto',
        'urlImagen'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto');
    }
}