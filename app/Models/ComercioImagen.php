<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ComercioImagen extends Model
{
    use HasFactory;

    protected $table = 'comercio_imagen';
    protected $primaryKey = 'id';
    
    public $timestamps = false;
    
    protected $fillable = [
        'idComercio',
        'urlImagen'
    ];

    protected $appends = ['imagen_url', 'tiene_imagen'];

    public function getImagenUrlAttribute()
    {
        if (empty($this->urlImagen)) {
            return null;
        }

        if (filter_var($this->urlImagen, FILTER_VALIDATE_URL)) {
            return $this->urlImagen;
        }

        return url('/shared-images/comercios/galeria/' . $this->urlImagen);
    }

    public function getTieneImagenAttribute()
    {
        if (empty($this->urlImagen)) {
            return false;
        }

        if (filter_var($this->urlImagen, FILTER_VALIDATE_URL)) {
            return true;
        }

        return Storage::disk('shared')->exists('comercios/galeria/' . $this->urlImagen);
    }

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'idComercio');
    }
}