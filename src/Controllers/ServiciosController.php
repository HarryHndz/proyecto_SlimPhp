<?php

namespace App\Controllers;
use App\Models\Hospedajes;
use App\Models\Paquetes;
use App\Models\Parques;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
class ServiciosController {
    function listah (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $datosHotel = Hospedajes::get();
        $params = ['categorias' => 'listaHotel','hoteles'=>$datosHotel,];
        return $view->render($response,'listahotel.html',$params);
    }
    function listapq (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $datosParques = Parques::get();
        $params = ['categorias' => 'listaparque','parques'=>$datosParques,];
        return $view->render($response,'listaparque.html',$params);
    }

    function listapts (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);

        $datosPaquetes = Paquetes::get();
        $params = ['categorias' => 'listapaquete','paquetes'=>$datosPaquetes];

        
        return $view->render($response,'listapaquete.html',$params);
    }
}

?>