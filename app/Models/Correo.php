<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    use HasFactory;

    protected $table = 'correo';
    protected $primaryKey = 'idCorreo';
    
    protected $fillable = [
        'correo',
        'idComercio'
    ];

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'idComercio');
    }
}