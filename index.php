<?php 
use App\Controllers\ConocenosController;
use App\Controllers\EventosController;
use App\Controllers\HotelesWebController;
use App\Controllers\InicioController;
use App\Controllers\ParquesWebController;
use App\Controllers\PaquetesWebController;
use App\Controllers\PlayasController;
use App\Controllers\ServiciosController;
use App\Controllers\SesionController;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Controllers\HomeController;
use App\Controllers\HotelController;
use App\Controllers\PaquetesController;
use App\Controllers\ParquesController;

require __DIR__ . "/vendor/autoload.php";

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
    "driver" => "mysql",
    "host"=> "127.0.0.1",
    "port" => "3306",
    "username"=> "root", //nombre de usuario
    "password"=> "", //contraseña
    "database"=> "pruebasmcv", //base de datos
    "charsert"=> "utf8",
    "collation"=> "utf8_general_ci",
    "prefix"=> ""
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$app = AppFactory::create();
$twig = Twig::create(['Templates/admin','Templates/web'], ['cache' => false]);
$app ->add(TwigMiddleware::create($app,$twig));

$app->setBasePath('/mcv_proyectoUt');


//rutas de admin

$app->get('/home', HomeController::class . ':index');



//rutas del apartado hoteles 
$app->get('/hotel', HotelController::class .':hoteles');
$app->post('/agregarHot', HotelController::class .':agregarHoteles');
$app->post('/actualizarHot', HotelController::class .':actualizarHoteles');
$app->post('/borrarHot', HotelController::class .':borrarHoteles');
$app->get('/actHot{id_hotel}', HotelController::class .':actHot');



//rutas del apartado paquetes
$app->get('/paquetes', PaquetesController::class .':paquetes');
$app->post('/agregarPaq', PaquetesController::class .':agregarPaquetes');
$app->post('/actualizarPaq', PaquetesController::class .':actualizarPaquetes');
$app->post('/borrarPaq', PaquetesController::class .':borrarPaquetes');
$app->get('/actPqt{id_paquete}', PaquetesController::class .':actPqt');


//rutas del aparatdo parques 
$app->get('/parques', ParquesController::class .':parques');
$app->post('/agregar', ParquesController::class .':agregarParque');
$app->post('/actualizar', ParquesController::class .':actualizarParque');
$app->post('/borrar', ParquesController::class .':borrarParque');
$app->get('/actPq{id_parque}', ParquesController::class .':actPq');

//rutas de las tablas de los registros
$app->get('/listaHoteles', ServiciosController::class .':listah');
$app->get('/listaParques', ServiciosController::class .':listapq');
$app->get('/listaPaquetes', ServiciosController::class .':listapts');

//------------------------------------------------------------------------------
//rutas de la web
$app->get('/conocenos',ConocenosController::class .':index');

$app->get('/eventos', EventosController::class .':index');

$app->get('/inicio',InicioController::class .':index');

$app->get('/playas',PlayasController::class .':index');
$app->get('/tabasco',PlayasController::class .':tabasco');
$app->get('/chiapas',PlayasController::class .':chiapas');
$app->get('/campeche',PlayasController::class .':campeche');
$app->get('/yucatan',PlayasController::class .':yucatan');
$app->get('/quintana',PlayasController::class .':quintana');

//$app->get('/registrase',);
//$app->get('/sesion',);
$app->get('/hotelesWeb',HotelesWebController::class .':index');
$app->get('/plantillaHotel{id_hotel}',HotelesWebController::class .':plantillaHotel');



$app->get('/parquesWeb',ParquesWebController::class .':index');
$app->post('/plantillaParque',ParquesWebController::class .':plantillaParque');


$app->get('/paquetesWeb',PaquetesWebController::class .':index');
$app->post('/plantillaPaquete',PaquetesWebController::class .':plantillaPaquete');


//controlador para las sesiones 
$app->get('/iniciarSesion',SesionController::class .':iniciar');
$app->get('/cerrarSesion',SesionController::class .':cerrarSesion');
$app->post('/validarSesion',SesionController::class .':validarSesion');
$app->get('/registrarUsuario',SesionController::class .':registrarse');
$app->post('/agregarUser',SesionController::class .':agregarUser');

$app->get('/sesionGoogle',SesionController::class .':sesionGoogle');


$app->run();
//nombre del cliente : harry
//id del cliente
// 79658555315-grl4hb05ikr38foqe5t3kmvfveafa041.apps.googleusercontent.com
//secreto o key del cliente
// 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
?>


