<?php

namespace App\Controllers;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use App\Models\Hospedajes;
include("./src/functions/vaciosNull.php");
class HotelController {
    function hoteles (Request $request, Response $response, array $args) {
        
        $view = Twig::fromRequest($request);
        $params = ['categorias' => 'hoteles'];
        return $view->render($response,'hospedaje.html',$params);
    }
    function agregarHoteles(Request $request, Response $response, array $args) {
        $datos = $request->getParsedBody();
        $imgHotel = $request->getUploadedFiles()['imgHotel'];
        if(esNulo($datos) && imGNul($imgHotel)){
            $camposVacios = esNulo($datos);
            $imagenNula = imGNul($imgHotel);
            $view = Twig::fromRequest($request);
            $params = ['categorias' => 'parques', 'vacio'=>$camposVacios , 'datos' =>$datos,'imgNula'=>$imagenNula];
            return $view->render($response, 'hospedaje.html', $params);

        }else{
            $Hoteles = new Hospedajes();
            $Hoteles->nombre = $datos['txtNombre'];
            $Hoteles->precio = $datos['txtPrecio'];
            $Hoteles->habitaciones = $datos['txtHabitaciones'];
            $Hoteles->descripcion = $datos['txtDescripcion'];
            $Hoteles->tipo_hospedaje = $datos['txtTipoHotel'];
            $Hoteles->direccion = $datos['txtDireccion'];
            $Hoteles->servicios = $datos['txtServicios'];
            
            
            $fecha = new DateTime();
            $nombreImagen = ($imgHotel->getError() === UPLOAD_ERR_OK) ? $fecha->getTimestamp() . "_" . $imgHotel->getClientFilename() : "imagen.jpg";
        
            if ($imgHotel->getError() === UPLOAD_ERR_OK) {
                $imgHotel->moveTo("./assets/img/" . $nombreImagen);
            }
        
            $Hoteles->imagenHotel = $nombreImagen;
            $Hoteles->save();
            return $response->withHeader('Location', 'hotel')->withStatus(302);
            }
    }

    function actualizarHoteles(Request $request, Response $response, array $args) {
        // Obtén el ID del formulario
        $datos = $request->getParsedBody();
        $idhotel = $datos['txtID'];
        $hotelExistente = Hospedajes::find($idhotel);        
        $nuevaImagen = $request->getUploadedFiles()['imgHotel'];

            $imagenAnterior = $hotelExistente->imagenHotel;
            if ($imagenAnterior && file_exists("./assets/img/" . $imagenAnterior)) {
                unlink("./assets/img/" . $imagenAnterior);
            }
            $fecha = new DateTime();
            $nombreNuevaImagen = ($nuevaImagen->getError() === UPLOAD_ERR_OK) ? $fecha->getTimestamp() . "_" . $nuevaImagen->getClientFilename() : $imagenAnterior;
            
            if ($nuevaImagen->getError() === UPLOAD_ERR_OK) {
                $nuevaImagen->moveTo("./assets/img/" . $nombreNuevaImagen);
                $hotelExistente->imagenHotel = $nombreNuevaImagen;
            }

        $hotelExistente->nombre = $datos['txtNombre'];
        $hotelExistente->precio = $datos['txtPrecio'];
        $hotelExistente->habitaciones = $datos['txtHabitaciones'];
        $hotelExistente->descripcion = $datos['txtDescripcion'];
        $hotelExistente->tipo_hospedaje = $datos['txtTipoHotel'];
        $hotelExistente->direccion = $datos['txtDireccion'];
        $hotelExistente->servicios = $datos['txtServicios'];
        $hotelExistente->save();
        return $response->withHeader('Location', 'hotel')->withStatus(302);
    }
    
    function borrarHoteles(Request $request, Response $response, array $args) {
        // Obtén el ID del formulario
        $data = $request->getParsedBody();
        $id = $data['txtID'];
        $user = Hospedajes::find($id);
        $imagenAnterior = $user->imagenHotel;
        if ($imagenAnterior && file_exists("./assets/img/" . $imagenAnterior)) {
            unlink("./assets/img/" . $imagenAnterior);
        }
        $user->delete();
        return $response->withHeader('Location', 'listaHoteles')->withStatus(302);
    }


    function actHot (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        $id = $args['id_hotel'] ?? null;
        
        if ($id != null) {
            $datos = Hospedajes::where('id_hospedaje',$id)->get();
            $params = ['idActulizar' => $datos,];
            return $view->render($response,'hospedaje.html',$params);
        } else {
            return $response->withStatus(400); 
        } 
    }
}

?>

