<?php

namespace App\Controllers;
use App\Models\Paquetes;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
include("./src/functions/vaciosNull.php");
class PaquetesController {
    function paquetes (Request $request, Response $response, array $args) {

        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'paquetes'];
        return $view->render($response,'paquetes.html',$params);
    }

    function agregarPaquetes(Request $request, Response $response, array $args) {
        // Obtén los datos del formulario
        $datos = $request->getParsedBody();
        $imgPaquete = $request->getUploadedFiles()['imgPaquete'];
        if(esNulo($datos) && imGNul($imgPaquete)){
            $camposVacios = esNulo($datos);
            $imagenNula = imGNul($imgPaquete);
            $view = Twig::fromRequest($request);
            $params = ['categorias' => 'parques', 'vacio'=>$camposVacios , 'datos' =>$datos ,'imgNula'=>$imagenNula];
            return $view->render($response, 'paquetes.html', $params);

        }else{
            $Paquetes = new Paquetes();
            $Paquetes->nombre = $datos['txtNombre'];
            $Paquetes->precio = $datos['txtPrecio'];
            $Paquetes->descripcion = $datos['txtDescripcion'];
            $Paquetes->servicios = $datos['txtServicios'];
            $Paquetes->tipo_paquete = $datos['txtTipoPaquete'];
            $fecha = new DateTime();
            $nombreImagen = ($imgPaquete->getError() === UPLOAD_ERR_OK) ? $fecha->getTimestamp() . "_" . $imgPaquete->getClientFilename() : "imagen.jpg";
        
            if ($imgPaquete->getError() === UPLOAD_ERR_OK) {
                $imgPaquete->moveTo("./assets/img/" . $nombreImagen);
            }
        
            $Paquetes->imagenPaquete = $nombreImagen;
            $Paquetes->save();
            return $response->withHeader('Location', 'paquetes')->withStatus(302);
        }
        
    }
    function actualizarPaquetes(Request $request, Response $response, array $args) {
        $datos = $request->getParsedBody();
        $idPaquete = $datos['txtID'];
        $paqueteExistente = Paquetes::find($idPaquete);        
        $nuevaImagen = $request->getUploadedFiles()['imgPaquete'];

            $imagenAnterior = $paqueteExistente->imagenPaquete;
            if ($imagenAnterior && file_exists("./assets/img/" . $imagenAnterior)) {
                unlink("./assets/img/" . $imagenAnterior);
            }
            $fecha = new DateTime();
            $nombreNuevaImagen = ($nuevaImagen->getError() === UPLOAD_ERR_OK) ? $fecha->getTimestamp() . "_" . $nuevaImagen->getClientFilename() : $imagenAnterior;
            
            if ($nuevaImagen->getError() === UPLOAD_ERR_OK) {
                $nuevaImagen->moveTo("./assets/img/" . $nombreNuevaImagen);
                $paqueteExistente->imagenPaquete = $nombreNuevaImagen;
            }
        

        $paqueteExistente->nombre = $datos['txtNombre'];
        $paqueteExistente->precio = $datos['txtPrecio'];
        $paqueteExistente->descripcion = $datos['txtDescripcion'];
        $paqueteExistente->tipo_paquete = $datos['txtTipoPaquete'];
        $paqueteExistente->servicios = $datos['txtServicios'];
        $paqueteExistente->save();
        return $response->withHeader('Location', 'paquetes')->withStatus(302);
    }
    
    function borrarPaquetes(Request $request, Response $response, array $args) {
        // Obtén el ID del formulario
        $data = $request->getParsedBody();
        $id = $data['txtID'];
        $user = Paquetes::find($id);
        $imagenAnterior = $user->imagenPaquete;
        if ($imagenAnterior && file_exists("./assets/img/" . $imagenAnterior)) {
            unlink("./assets/img/" . $imagenAnterior);
        }
        $user->delete();
        return $response->withHeader('Location', 'listaPaquetes')->withStatus(302);
    }

    function actPqt (Request $request, Response $response, array $args) {

        $view = Twig::fromRequest($request);
        $id = $args['id_paquete'] ?? null;
        
        if ($id != null) {
            $datos = Paquetes::where('id_paquete',$id)->get();
            $params = ['idActulizar' => $datos,];
            return $view->render($response,'paquetes.html',$params);
        } else {
            return $response->withStatus(400); 
        } 
    }


}

?>