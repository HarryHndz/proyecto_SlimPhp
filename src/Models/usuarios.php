<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Usuarios extends Eloquent {
    protected $table = "usuarios";
    protected $fillable = [
        "nombre",
        "apellidos",
        "usuario",
        "email",
        "contraseña",
        ];
    
    protected $primaryKey = 'id_usuario';
    public $timestamps = [];

}
