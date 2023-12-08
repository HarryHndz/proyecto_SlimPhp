<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class TipoHospedaje extends Eloquent {
    protected $table = "tipo_hospedaje";
    protected $fillable = [
        "id_tipohospedaje",
        "nombre",
        ];
    

    public $timestamps = [];

}
