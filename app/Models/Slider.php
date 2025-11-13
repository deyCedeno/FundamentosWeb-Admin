<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected $appends = ['imagen_url', 'tiene_imagen'];

    // Accesor para obtener la URL completa de la imagen
    public function getImagenUrlAttribute()
    {
        if (empty($this->imagen)) {
            return null;
        }

        // Verificar si el archivo existe físicamente
        $rutaFisica = 'C:/laravel/shared-images/sliders/' . $this->imagen;
        if (!file_exists($rutaFisica)) {
            return null;
        }

        // URL temporal - apuntar directamente al archivo físico
        // Esto funcionará incluso sin el enlace simbólico
        $url = url('/shared-images/sliders/' . $this->imagen);
        
        return $url;
    }

    // Método para verificar si la imagen existe
    public function getTieneImagenAttribute()
    {
        if (empty($this->imagen)) {
            return false;
        }
        
        $rutaCompleta = 'C:/laravel/shared-images/sliders/' . $this->imagen;
        return file_exists($rutaCompleta);
    }
}