<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comercio extends Model
{
    use HasFactory;

    protected $table = 'comercio';
    protected $primaryKey = 'idComercio';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'dirección',
        'facebook',
        'instagram',
        'urlMapa',
        'imagenDestacada'
    ];

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'comercio_categoria', 'idComercio', 'idCategoria');
    }

    public function telefonos()
    {
        return $this->hasMany(Telefono::class, 'idComercio');
    }

    public function correos()
    {
        return $this->hasMany(Correo::class, 'idComercio');
    }

    public function imagenes()
    {
        return $this->hasMany(ComercioImagen::class, 'idComercio');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'idComercio');
    }
}