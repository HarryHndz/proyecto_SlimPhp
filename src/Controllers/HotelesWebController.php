<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use App\Models\Hospedajes;
include("./src/apis/apiClima.php");
class HotelesWebController {
    function index (Request $request, Response $response, array $args) {
        $datos = Hospedajes::get();
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'hotelesWeb','datosHoteles'=>$datos];

        
        return $view->render($response,'hoteles.html',$params);
    }

    function plantillaHotel (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        // $parsedBody = $request->getParsedBody();
        // $id = $parsedBody['id_Hotel'] ?? null;
        $id = $args['id_hotel'];
        if ($id != null) {
            // $datos = Hospedajes::find($id);
            $datos = Hospedajes::where('id_hospedaje',$id)->get();
            $direc = $datos[0]['direccion'];
            $ApiClima = Clima($direc);
            $urlMaps= "https://maps.googleapis.com/maps/api/js?key=AIzaSyB9hliQLrDnkSVQIpoooJjZk9h938UISrI&callback=initMap&v=weekly&callback=initMap";
            $params = ['plantHoteles' => $datos,'clima'=>$ApiClima, 'maps'=>$urlMaps];
            return $view->render($response, 'plantillaHotel.html', $params);
        } else {
            $response->getBody()->write('Error: No se proporcionó un ID de hotel.');
            return $response->withStatus(400);  // Código de estado HTTP 400 para "Bad Request"
        }
    }
}


?>