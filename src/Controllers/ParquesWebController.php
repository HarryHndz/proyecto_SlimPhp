<?php

namespace App\Controllers;
use App\Models\Parques;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
class ParquesWebController{
    function index (Request $request, Response $response, array $args) {

        $datos = Parques::get();
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'parquesWeb','datosParques'=>$datos];
        
        return $view->render($response,'parques2.html',$params);
    }

    function plantillaParque (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $parsedBody = $request->getParsedBody();
        $id = $parsedBody['id_parque'] ?? null;
    
        if ($id != null) {
            $datos = Parques::find($id);
            $urlMaps= "https://maps.googleapis.com/maps/api/js?key=AIzaSyB9hliQLrDnkSVQIpoooJjZk9h938UISrI&callback=initMap&v=weekly&callback=initMap";
            $params = ['plantParques' => $datos,'maps'=>$urlMaps];
            
            return $view->render($response, 'plantillaParques.html', $params);
        } else {
            $response->getBody()->write('Error: No se proporcionó un ID de parque.');
            return $response->withStatus(400);  // Código de estado HTTP 400 para "Bad Request"
        }
    }


}

?>