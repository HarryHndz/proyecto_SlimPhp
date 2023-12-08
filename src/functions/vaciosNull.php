<?php 

function esNulo(array $parametros){
    $campos = array();
    foreach ($parametros as $nombre => $valor) {
        if(empty($valor)){
            $campos[] = $nombre ;
        }
    }
    
    return $campos;
}
function imGNul ($parametro){
    if ($parametro->getSize()<0){
        return true;
    }
    return false;
}


function validaContraseña($contraseña,$confirmarContraseña){
    if (strcmp($contraseña,$confirmarContraseña)===0) {
        return true;
    }
    return false;
}


?>