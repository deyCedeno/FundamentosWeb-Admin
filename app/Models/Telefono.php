<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    use HasFactory;

    protected $table = 'telefono';
    protected $primaryKey = 'idTelefono';
    public $timestamps = false;
    
    protected $fillable = [
        'telefono',
        'idComercio'
    ];

    public function comercio()
    {
        return $this->belongsTo(Comercio::class, 'idComercio');
    }
}