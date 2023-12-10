<?php

namespace App\Controllers;
use App\Models\Hospedajes;
use App\Models\Paquetes;
use App\Models\Parques;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
class BuscarController {
    function busqueda (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $datos = $request->getParsedBody();

        if(isset($datos["busqueda"])){
            $datosHoteles = Hospedajes::select('nombre', 'precio','descripcion', 'imagenHotel as ruta_imagen')->where('nombre','like','%'.$datos["busqueda"].'%')->get();
            $datosPaquetes = Paquetes::select('nombre', 'precio','descripcion', 'imagenPaquete as ruta_imagen')->where('nombre','like','%'.$datos["busqueda"].'%')->get();
            $datosParques = Parques::select('nombre', 'precio','descripcion', 'imagenParque as ruta_imagen')->where('nombre','like','%'.$datos["busqueda"].'%')->get();
            $resultadoFinal = $datosHoteles->merge($datosPaquetes)->merge($datosParques);
            $params= ['resultado'=>$resultadoFinal];
            return $view->render($response,'resultados.html',$params);
        }else{
            $llene = 'introduzca datos';
            $params =['vacioo'=>$llene , 'dato'=> $datos["busqueda"]];
            return $view->render($response,'inicio.html',$params);
        }

        
        
    }
}

?>