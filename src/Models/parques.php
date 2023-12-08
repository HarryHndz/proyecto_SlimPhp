<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Parques extends Eloquent {
    protected $table = "parques";
    protected $fillable = [
        "nombre",
        "precio",
        "descripcion",
        "imagenParque"
        ];
    
        protected $primaryKey = 'id_parque';
    public $timestamps = [];

}
