<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'tipoProducto',
        'imagenDestacada',
        'idComercio'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'idComercio');
    }

    public function imagenes()
    {
        return $this->hasMany(ProductoImagen::class, 'idProducto');
    }
}