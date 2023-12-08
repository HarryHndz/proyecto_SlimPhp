<?php

namespace App\Controllers;
use App\Models\Administrador;
use App\Models\Usuarios;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
include("./src/functions/vaciosNull.php");


class SesionController {
    function registrarse (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'registrarse'];

        
        return $view->render($response,'registrarse.html',$params);
    }

    function iniciar (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'iniciar_sesion'];

        
        return $view->render($response,'sesion.html',$params);
    }
    function agregarUser (Request $request, Response $response, array $args) {
        $datos = $request->getParsedBody();
        if(esNulo($datos)){
            $view = Twig::fromRequest($request);
            $camposVacios = esNulo($datos);
            if(!validaContraseña($datos['contraseña'],$datos['confirmarContraseña'])){
                $contraseñaMal = "las contraseñas no coinciden";
                $params = ['categorias' => 'registrarse','contra'=>$contraseñaMal,'datos' =>$datos,'vacio'=>$camposVacios ];
                return $view->render($response, 'registrarse.html', $params);
            }
        }else{
            $registro = new Usuarios;
            $registro->nombre = $datos['nombre'];
            $registro->apellidos = $datos['apellidos'];
            $registro->usuario = $datos['usuario'];
            $registro->email = $datos['email'];
            $registro->contraseña = $datos['contraseña'];
            $registro->save();
            return $response->withHeader('Location', 'iniciarSesion')->withStatus(302);
        }
    }
    
    
    function validarSesion (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $datosInicio = $request->getParsedBody();
        if(esNulo($datosInicio)){
            $camposVacios = esNulo($datosInicio);
            $params = ['categorias' => 'iniciar_sesion', 'vacio'=>$camposVacios];
            return $view->render($response, 'sesion.html', $params);
        
        }else{
            $user = $datosInicio['usuario'];
            $contraseña = $datosInicio['contraseña'];
            session_start();
            $usuarioEncontrado = Usuarios::where('usuario', $user)->first();

            if(($user== $usuarioEncontrado->usuario && $contraseña == $usuarioEncontrado->contraseña)){

                $_SESSION['usuario'] = $usuarioEncontrado;
                $params = ['sesion'=>$_SESSION['usuario']];
                return $view->render($response,'inicio.html',$params);

            }elseif(($user!= $usuarioEncontrado->usuario && $contraseña != $usuarioEncontrado->contraseña)
            || ($user!= $usuarioEncontrado->usuario || $contraseña != $usuarioEncontrado->contraseña)){

                $message = 'error el usuario o contraseña son incorrectos';
                $params = ['categorias' => 'iniciar_sesion', 'msgError'=>$message, 'data'=>$datosInicio];
                return $view->render($response, 'sesion.html', $params);
        
            }
        }
        
    }

    function cerrarSesion (Request $request, Response $response, array $args) {
        session_start();
        session_destroy();
        return $response->withHeader('Location', 'inicio')->withStatus(302);
    }



    function iniciarAdmin (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'iniciar_sesion'];

        
        return $view->render($response,'sesionAdmin.html',$params);
    }




    function sesionAdmin (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $datosInicio = $request->getParsedBody();
        if(esNulo($datosInicio)){
            $camposVacios = esNulo($datosInicio);
            $params = ['vacio'=>$camposVacios];
            return $view->render($response, 'sesionAdmin.html', $params);
        
        }else{
            $user = $datosInicio['usuario'];
            $contraseña = $datosInicio['contraseña'];
            session_start();
            $usuarioEncontrado = Administrador::where('usuario', $user)->first();

            if(($user== $usuarioEncontrado->usuario && $contraseña == $usuarioEncontrado->contraseña)){

                $_SESSION['usuario'] = $usuarioEncontrado;
                $params = ['sesion'=>$_SESSION['usuario']];
                return $view->render($response,'home.html',$params);

            }elseif(($user!= $usuarioEncontrado->usuario && $contraseña != $usuarioEncontrado->contraseña)
            || ($user!= $usuarioEncontrado->usuario || $contraseña != $usuarioEncontrado->contraseña)){

                $message = 'error el usuario o contraseña son incorrectos';
                $params = ['msgError'=>$message, 'data'=>$datosInicio];
                return $view->render($response, 'sesionAdmin.html', $params);
        
            }
        }
        
    }


    function cerrarSesionAdmin (Request $request, Response $response, array $args) {
        session_start();
        session_destroy();
        return $response->withHeader('Location', 'iniciarAdmin')->withStatus(302);
    }

    
}

?>
