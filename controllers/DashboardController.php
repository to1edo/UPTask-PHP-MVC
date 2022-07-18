<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController{

    public static function index(Router $router){

        session_start();
        isAuth();

        $proyectos = Proyecto::whereAll('propietarioId',$_SESSION['id']);
        
        $router->render('/dashboard/index',[
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function crear(Router $router){

        session_start();
        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarNombre();

            if(empty($alertas)){

                //generar url unica
                $proyecto->url = md5(uniqid());
                $proyecto->propietarioId = $_SESSION['id'];

                //guardar proyecto
                $proyecto->guardar();

                // redireccionar hacia el proyecto creado
                header('Location: /proyecto?id='.$proyecto->url);
            
            }
        }


        $alertas = Proyecto::getAlertas();

        $router->render('/dashboard/crear-proyecto',[
            'titulo' => 'Crear proyecto',
            'alertas' => $alertas
        ]);
    }

    public static function proyecto(Router $router){

        session_start();  
        isAuth();

        $token = $_GET['id'];
        
        if(!$token){
            header('Location: /dashboard');
        }

        $proyecto = Proyecto::where('url',$token);
        
        //revisar el propietario del proyecto
        if($proyecto && $proyecto->propietarioId === $_SESSION['id']){

        }else{
            header('Location: /dashboard');
        }

        $router->render('/dashboard/proyecto',[
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function eliminar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            session_start();

            $proyecto = Proyecto::where('id',$_POST['proyectoUrl']);
            
            if($proyecto && $proyecto->propietarioId === $_SESSION['id']){

                $proyecto->eliminar();

                $respuesta = [
                        'tipo' => 'success' , 
                        'mensaje'=> 'Proyecto borrado'
                ];
                echo json_encode($respuesta);

            }else{
                
                $respuesta = [
                    'tipo' => 'error' , 
                    'mensaje'=> 'Error al intentar borrar el proyecto'
               ];
               echo json_encode($respuesta);            
            }
        }
    }

    public static function perfil(Router $router){

        session_start();   
        isAuth();

        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPerfil();
            $resultado = $usuario->where('email',$usuario->email);

            if( $resultado && $resultado->id !== $usuario->id){
                $usuario->setAlerta('error','El email esta siendo usado en otra cuenta');
            }

            $alertas = $usuario->getAlertas();

            if(empty($alertas)){

                $usuario->guardar();

                $_SESSION['nombre'] = $usuario->nombre;
                $_SESSION['email'] = $usuario->email;

                $usuario->setAlerta('exito','Datos Actualizados');
                $alertas = $usuario->getAlertas();
            }

        }

        $router->render('/dashboard/perfil',[
            'titulo' => 'Editar mis Datos',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function cambiarPassword(Router $router){
        session_start();   
        isAuth();
        
        $usuario = new Usuario();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario = Usuario::find($_SESSION['id']);

            $usuario->validarNuevaPassword($_POST);
            $alertas = $usuario->getAlertas();

            if(empty($alertas)){
                
                $resultado = $usuario->verificarPassword($_POST['passwordActual']);

                if($resultado){

                    $usuario->password = $_POST['passwordNueva'];
                    $usuario->hashPassword();
                    $usuario->guardar();

                    $usuario->setAlerta('exito','Password Cambiado!');
                    
                }else{
                    $usuario->setAlerta('error','Password Actual incorrecto');
                }
            }
        }
        
        $alertas = $usuario->getAlertas();

        $router->render('/dashboard/cambiar-password',[
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
        ]);
    }
}