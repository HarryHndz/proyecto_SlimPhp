<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
class Paquetes extends Eloquent {
    protected $table = "paquetes";
    protected $fillable = [
        "nombre",
        "precio",
        "descripcion",
        "servicios",
        "tipo_paquete",
        "imagenPaquete"
        ];
    protected $primaryKey = 'id_paquete';
    public $timestamps = [];

}

?>