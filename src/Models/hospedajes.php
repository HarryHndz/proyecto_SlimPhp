<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Hospedajes extends Eloquent {
    protected $table = "hospedaje";
    protected $fillable = [
        "nombre",
        "precio",
        "habitaciones",
        "descripcion",
        "tipo_hospedaje",
        "direccion",
        "servicios",
        "imagenHotel"
        ];
    
    protected $primaryKey = 'id_hospedaje';

    public $timestamps = [];

}




?>