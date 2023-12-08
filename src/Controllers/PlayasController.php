<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
include("./src/apis/apiClima.php");
class PlayasController {
    
    function index (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'playas'];

        
        return $view->render($response,'playas.html',$params);
    }
    function tabasco (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $tabasco= 'tabasco';
        $climita = Clima($tabasco);
        $idvideo = 'noJ6i36csXQ';
        $urlMaps= "https://maps.googleapis.com/maps/api/js?key=AIzaSyB9hliQLrDnkSVQIpoooJjZk9h938UISrI&callback=initMap&v=weekly&callback=initMap";
        $params = ['categorias' => 'playas_chia','apiClima'=>$climita,'maps'=>$urlMaps,'video' =>$idvideo];
        
        return $view->render($response,'infotab.html',$params);
    }
    function yucatan (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $yucatan= 'yucatan';
        $climita = Clima($yucatan);
        $idvideo = 'aDjSaYjccbE';
        $urlMaps= "https://maps.googleapis.com/maps/api/js?key=AIzaSyB9hliQLrDnkSVQIpoooJjZk9h938UISrI&callback=initMap&v=weekly&callback=initMap";
        $params = ['categorias' => 'playas_chia','apiClima'=>$climita,'maps'=>$urlMaps,'video' =>$idvideo];

        
        return $view->render($response,'infoyuca.html',$params);
    }
    function quintana (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $quintana= 'Quintana Roo';
        $climita = Clima($quintana);
        $idvideo = 'jnbG-1MbFWg';
        $urlMaps= "https://maps.googleapis.com/maps/api/js?key=AIzaSyB9hliQLrDnkSVQIpoooJjZk9h938UISrI&callback=initMap&v=weekly&callback=initMap";
        $params = ['categorias' => 'playas_chia','apiClima'=>$climita,'maps'=>$urlMaps,'video' =>$idvideo];

        
        return $view->render($response,'infoqroo.html',$params);
    }
    function campeche (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $campeche= 'campeche';
        $climita = Clima($campeche);
        $urlMaps= "https://maps.googleapis.com/maps/api/js?key=AIzaSyB9hliQLrDnkSVQIpoooJjZk9h938UISrI&callback=initMap&v=weekly&callback=initMap";
        $idvideo = 'HvBIXBIGt3k';
        $params = ['categorias' => 'playas_chia','apiClima'=>$climita,'maps'=>$urlMaps, 'video' =>$idvideo];

        
        return $view->render($response,'infocamp.html',$params);
    }
    function chiapas (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $chiapas= 'chiapas';
        $climita = Clima($chiapas);
        $idvideo = 'KeQ___kEs2Q';
        $urlMaps= "https://maps.googleapis.com/maps/api/js?key=AIzaSyB9hliQLrDnkSVQIpoooJjZk9h938UISrI&callback=initMap&v=weekly&callback=initMap";
        $params = ['categorias' => 'playas_chia','apiClima'=>$climita,'maps'=>$urlMaps,'video' =>$idvideo];

        return $view->render($response,'infochia.html',$params);
    }


}

?>