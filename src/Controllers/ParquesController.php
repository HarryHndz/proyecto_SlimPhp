<?php

namespace App\Controllers;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
include("./src/functions/vaciosNull.php");
use Slim\Views\Twig;
use App\Models\Parques;
class ParquesController {
    function parques (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'parques'];
        return $view->render($response, 'parques.html', $params);
    }

    function agregarParque(Request $request, Response $response, array $args) {
        // Obtén los datos del formulario
        $datos = $request->getParsedBody();
        $imgParque = $request->getUploadedFiles()['imgParque'];
        if(esNulo($datos) && imGNul($imgParque)){
            $camposVacios = esNulo($datos);
            $imagenNula = imGNul($imgParque);
            $view = Twig::fromRequest($request);
            $params = ['categorias' => 'parques', 'vacio'=>$camposVacios , 'datos' =>$datos,'imgNula'=>$imagenNula];
            return $view->render($response, 'parques.html', $params);
        } else{
            $Parques = new Parques();
            $Parques->nombre = $datos['txtNombre'];
            $Parques->precio = $datos['txtPrecio'];
            $Parques->descripcion = $datos['txtDescripcion'];
            
            
            $fecha = new DateTime();
            $nombreImagen = ($imgParque->getError() === UPLOAD_ERR_OK) ? $fecha->getTimestamp() . "_" . $imgParque->getClientFilename() : "imagen.jpg";
        
            if ($imgParque->getError() === UPLOAD_ERR_OK) {
                $imgParque->moveTo("./assets/img/" . $nombreImagen);
            }
        
            $Parques->imagenParque = $nombreImagen;
            $Parques->save();
            return $response->withHeader('Location', 'parques')->withStatus(302);
            }
        
    }

    function actualizarParque(Request $request, Response $response, array $args) {
        // Obtén el ID del formulario
        $datos = $request->getParsedBody();
        $idParque = $datos['txtID'];
        $parqueExistente = Parques::find($idParque);

        
        $nuevaImagen = $request->getUploadedFiles()['imgParque'];

            $imagenAnterior = $parqueExistente->imagenParque;
            if ($imagenAnterior && file_exists("./assets/img/" . $imagenAnterior)) {
                unlink("./assets/img/" . $imagenAnterior);
            }
            $fecha = new DateTime();
            $nombreNuevaImagen = ($nuevaImagen->getError() === UPLOAD_ERR_OK) ? $fecha->getTimestamp() . "_" . $nuevaImagen->getClientFilename() : $imagenAnterior;
            
            if ($nuevaImagen->getError() === UPLOAD_ERR_OK) {
                $nuevaImagen->moveTo("./assets/img/" . $nombreNuevaImagen);
                $parqueExistente->imagenParque = $nombreNuevaImagen;
            }

        $parqueExistente->nombre = $datos['txtNombre'];
        $parqueExistente->precio = $datos['txtPrecio'];
        $parqueExistente->descripcion = $datos['txtDescripcion'];
        $parqueExistente->save();
        return $response->withHeader('Location', 'parques')->withStatus(302);
    }
    
    function borrarParque(Request $request, Response $response, array $args) {
        // Obtén el ID del formulario
        $data = $request->getParsedBody();
        $id = $data['txtID'];
        $user = Parques::find($id);
        $imagenAnterior = $user->imagenParque;
        if ($imagenAnterior && file_exists("./assets/img/" . $imagenAnterior)) {
            unlink("./assets/img/" . $imagenAnterior);
        }
        $user->delete();
        return $response->withHeader('Location', 'listaParques')->withStatus(302);
    }

    function actPq (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $id = $args['id_parque'] ?? null;
        
        if ($id != null) {
            $datos = Parques::where('id_parque',$id)->get();
            $params = ['idActulizar' => $datos,];
            return $view->render($response,'parques.html',$params);
        } else {
            return $response->withStatus(400); 
        } 
    }

}


?>

