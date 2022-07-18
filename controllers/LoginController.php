<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Locale;
use Model\Usuario;

class LoginController{

    public static function login(Router $router){

        $usuario = New Usuario();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarLogin();

            if(empty($alertas)){

                $resultado = Usuario::where('email',$usuario->email);

                if(!empty($resultado)){

                    //validar password
                    $auth = $usuario->passwordAndConfirmado($resultado);

                    if($auth){
                        session_start();

                        $_SESSION['id'] = $resultado->id;
                        $_SESSION['nombre'] =$resultado->nombre .' '. $resultado->apellido;
                        $_SESSION['email'] = $resultado->email;
                        $_SESSION['login'] = true;

                        //redireccionas
                        header('Location: /dashboard');
                    }

                }else{
                    Usuario::setAlerta('error','El email no esta registrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'titulo' => 'Iniciar sesion',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);

    }

    public static function logout(){
        
        session_start();
        $_SESSION = [];

        header('Location: /');
        
    }

    public static function crear(Router $router){
        $alertas = [];
        $usuario = new Usuario();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarNuevaCuenta();
            $usuario->existeUsuario();

            $alertas = Usuario::getAlertas();
            if(empty($alertas)){
                
                $usuario->sincronizar($_POST);

                //hashear password
                $usuario->hashPassword();
                
                //Generar token para el usuario
                $usuario->crearToken();

                //enviar el email para confirmar la cuenta
                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                $email->enviarConfirmacion();

                //guardar en DB
                $resultado = $usuario->guardar();

                if($resultado)
                {
                    header('Location: /mensaje');
                }
                    
                
            }

        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/crear',[
            'titulo'=> 'Crear cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)){

                $usuario = Usuario::where('email',$usuario->email);
                
                if($usuario && $usuario->confirmado === '1'){
                    //Generar token para el usuario
                    $usuario->crearToken();

                    //Actalizaren la BD
                    $usuario->guardar();

                    //enviar el email para confirmar la cuenta
                    $mail = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $mail->enviarRestablecer();
                    
                    Usuario::setAlerta('exito','Revisa el email que te hemos enviado');
                }else{
                    Usuario::setAlerta('error','Email no valido o el usuario no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide',[
            'titulo'=> 'Olvide mi password',
            'alertas' => $alertas
        ]);
    }

    public static function restablecer(Router $router){
        
        $alertas = [];
        $valido = false;

        $token =  s($_GET['token']) ?? '';

        if(!$token){
            header('Location: /');
        }
    
        $usuario = Usuario::where('token',$token);

        if($usuario){
            $valido = true;
        }else{
            $valido = false;
        }
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $resultado = new Usuario($_POST);
            $alertas = $resultado->validarPassword();


            if(empty($alertas)){
                //restablecer el password
                $usuario->password = $resultado->password;
                $usuario->hashPassword();
                $usuario->token = '0';
                
                //acutlizar en la BD
                $usuario->guardar();

                Usuario::setAlerta('exito','El password fue restablecido');
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/restablecer',[
            'titulo'=> 'Restablecer password',
            'confirmado' => $valido,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje',[
            'titulo'=> 'Mensaje'
        ]);  
    }

    public static function confirmar(Router $router){

        $token = $_GET['token'];

        $resultado = Usuario::where('token',$token);

        if($resultado){
            $resultado->token = '0';
            $resultado->confirmado = 1;
            $resultado->guardar();

            $confirmado = true;
        }else{
            $confirmado = false;
        }

        $router->render('auth/confirmar',[
            'titulo'=> 'Confirmado',
            'confirmado' => $confirmado
        ]);  
    }

}