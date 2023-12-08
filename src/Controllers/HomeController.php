<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
class HomeController {
    function index (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'home'];

        
        return $view->render($response,'home.html',$params);
    }
}

?>