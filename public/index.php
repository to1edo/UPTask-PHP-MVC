<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\TareasController;
use Controllers\DashboardController;
$router = new Router();

//Login
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
$router->get('/logout',[LoginController::class,'logout']);

//crear cuenta
$router->get('/crear',[LoginController::class,'crear']);
$router->post('/crear',[LoginController::class,'crear']);

//confirmar cuenta
$router->get('/mensaje',[LoginController::class,'mensaje']);
$router->get('/confirmar',[LoginController::class,'confirmar']);

//formulario de olvide mi password
$router->get('/olvide',[LoginController::class,'olvide']);
$router->post('/olvide',[LoginController::class,'olvide']);

//restablecer el password
$router->get('/restablecer',[LoginController::class,'restablecer']);
$router->post('/restablecer',[LoginController::class,'restablecer']);

//dashboard
$router->get('/dashboard',[DashboardController::class,'index']);
$router->get('/crear-proyecto',[DashboardController::class,'crear']);
$router->post('/crear-proyecto',[DashboardController::class,'crear']);
$router->get('/proyecto',[DashboardController::class,'proyecto']);
$router->post('/proyecto/eliminar',[DashboardController::class,'proyecto']);
$router->get('/perfil',[DashboardController::class,'perfil']);
$router->post('/perfil',[DashboardController::class,'perfil']);
$router->get('/cambiar-password',[DashboardController::class,'cambiarPassword']);
$router->post('/cambiar-password',[DashboardController::class,'cambiarPassword']);

//API para tareas
$router->get('/api/tarea',[TareasController::class,'index']);
$router->post('/api/tarea',[TareasController::class,'crear']);
$router->post('/api/tarea/actualizar',[TareasController::class,'actualizar']);
$router->post('/api/tarea/eliminar',[TareasController::class,'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();