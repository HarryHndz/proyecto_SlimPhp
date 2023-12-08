<?php

namespace App\Controllers;
use App\Models\Paquetes;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
class PaquetesWebController{
    function index (Request $request, Response $response, array $args) {
        $datos = Paquetes::get();
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'paquetesWeb','datosPaquetes'=>$datos];

        
        return $view->render($response,'paquetes2.html',$params);
    }

    function plantillaPaquete (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $parsedBody = $request->getParsedBody();
        $id = $parsedBody['id_paquete'] ?? null;
    
        if ($id != null) {
            $datos = Paquetes::find($id);
            $params = ['plantPaquetes' => $datos];
            return $view->render($response, 'plantillaPaquetes.html', $params);
        } else {
            $response->getBody()->write('Error: No se proporcionó un ID de paquete.');
            return $response->withStatus(400);  // Código de estado HTTP 400 para "Bad Request"
        }
    }

}

?>