<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;
    
    // Indicar que la clave primaria es auto-incremental
    public $incrementing = true;
    
    // Especificar el tipo de clave primaria
    protected $keyType = 'int';
    
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
        return url('/shared-images/productos/' . $this->imagenDestacada);
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
        return Storage::disk('shared')->exists('productos/' . $this->imagenDestacada);
    }

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'idComercio');
    }

    public function imagenes()
    {
        return $this->hasMany(ProductoImagen::class, 'idProducto');
    }
}