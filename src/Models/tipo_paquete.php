<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class TipoPaquete extends Eloquent {
    protected $table = "tipo_paquete";
    protected $fillable = [
        "id_tipoPaquete",
        "nombre",
        ];
    

    public $timestamps = [];

}