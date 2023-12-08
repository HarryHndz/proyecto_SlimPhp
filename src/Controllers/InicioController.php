<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
class InicioController {
    function index (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'inicio'];

        
        return $view->render($response,'inicio.html',$params);
    }
}

?>