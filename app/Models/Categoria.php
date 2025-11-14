<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categoria';
    protected $primaryKey = 'idCategoria';
    
    // Deshabilitar timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'urlImagen'
    ];

    // Agregar accessors al modelo
    protected $appends = ['imagen_url', 'tiene_imagen'];

    // Accesor para obtener la URL completa de la imagen
    public function getImagenUrlAttribute()
    {
        if (empty($this->urlImagen)) {
            return null;
        }

        // Si es una URL externa (como las de Unsplash), devolverla directamente
        if (filter_var($this->urlImagen, FILTER_VALIDATE_URL)) {
            return $this->urlImagen;
        }

        // Si es un archivo local, generar la URL
        return url('/shared-images/categorias/' . $this->urlImagen);
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
        return Storage::disk('shared')->exists('categorias/' . $this->urlImagen);
    }

    // Accesor para compatibilidad - usar el campo real de la BD
    public function getImagenAttribute()
    {
        return $this->urlImagen;
    }

    public function comercios()
    {
        return $this->belongsToMany(Comercio::class, 'comercio_categoria', 'idCategoria', 'idComercio');
    }

    public function comerciosCount()
    {
        return $this->comercios()->count();
    }
}