<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductoImagen extends Model
{
    use HasFactory;

    protected $table = 'producto_imagen';
    protected $primaryKey = 'id';
    
    // Deshabilitar timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'idProducto',
        'urlImagen'
    ];

    // Agregar accessors para las imágenes
    protected $appends = ['imagen_url', 'tiene_imagen'];

    // Accesor para obtener la URL completa de la imagen
    public function getImagenUrlAttribute()
    {
        if (empty($this->urlImagen)) {
            return null;
        }

        // Si es una URL externa, devolverla directamente
        if (filter_var($this->urlImagen, FILTER_VALIDATE_URL)) {
            return $this->urlImagen;
        }

        // Si es un archivo local, generar la URL
        return url('/shared-images/productos/galeria/' . $this->urlImagen);
    }

    // Método para verificar si la imagen existe
    public function getTieneImagenAttribute()
    {
        if (empty($this->urlImagen)) {
            return false;
        }

        // Si es una URL externa, asumir que existe
        if (filter_var($this->urlImagen, FILTER_VALIDATE_URL)) {
            return true;
        }

        // Si es un archivo local, verificar si existe
        return Storage::disk('shared')->exists('productos/galeria/' . $this->urlImagen);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto');
    }
}