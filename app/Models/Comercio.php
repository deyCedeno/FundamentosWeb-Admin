<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Comercio extends Model
{
    use HasFactory;

    protected $table = 'comercio';
    protected $primaryKey = 'idComercio';
    
    // Deshabilitar timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'dirección',
        'facebook',
        'instagram',
        'urlMapa',
        'imagenDestacada'
    ];

    // Agregar accessors para las imágenes
    protected $appends = ['imagen_destacada_url', 'tiene_imagen_destacada'];

    // Accesor para obtener la URL completa de la imagen destacada
    public function getImagenDestacadaUrlAttribute()
    {
        if (empty($this->imagenDestacada)) {
            return null;
        }

        // Si es una URL externa, devolverla directamente
        if (filter_var($this->imagenDestacada, FILTER_VALIDATE_URL)) {
            return $this->imagenDestacada;
        }

        // Si es un archivo local, generar la URL
        return url('/shared-images/comercios/' . $this->imagenDestacada);
    }

    // Método para verificar si la imagen destacada existe
    public function getTieneImagenDestacadaAttribute()
    {
        if (empty($this->imagenDestacada)) {
            return false;
        }

        // Si es una URL externa, asumir que existe
        if (filter_var($this->imagenDestacada, FILTER_VALIDATE_URL)) {
            return true;
        }

        // Si es un archivo local, verificar si existe
        return Storage::disk('shared')->exists('comercios/' . $this->imagenDestacada);
    }

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