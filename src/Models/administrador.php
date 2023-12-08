<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Administrador extends Eloquent {
    protected $table = "administrador";
    protected $fillable = [
        "usuario",
        "contraseña"
        ];
    
    protected $primaryKey = 'id_admin';
    public $timestamps = [];

}