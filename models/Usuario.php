<?php

namespace Model;

class Usuario extends ActiveRecord{

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','email','password','token','confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $token;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    //validaciones
    public function validarNuevaCuenta() {

        if(!$this->nombre){
            static::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->email){
            static::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->password){
            static::$alertas['error'][] = 'El password es obligatorio';     
        }else{
            if(strlen($this->password) < 6){
                static::$alertas['error'][] = 'El password debe tenar al menos 6 caracteres';
            }
            if($this->password !== $_POST['password2']){
                static::$alertas['error'][] = 'Los passwords no coinciden';
            }
        }

        return static::$alertas;
    }


    public function validarLogin() {

        if(!$this->email){
            static::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->password){
            static::$alertas['error'][] = 'El password es obligatorio';
        }elseif(strlen($this->password)<6){
            static::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }

        return static::$alertas;
    }

    public function validarPerfil() {

        if(!$this->email){
            static::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->nombre){
            static::$alertas['error'][] = 'El nombre es obligatorio';
        }

        return static::$alertas;
    }

    public function validarEmail() {

        if(!$this->email){
            static::$alertas['error'][] = 'El email es obligatorio';

            if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
                static::$alertas['error'][] = 'El no tiene un formato valido';
            }
        }

        return static::$alertas;
    }

    public function validarPassword() {

        if(!$this->password){
            static::$alertas['error'][] = 'El password es obligatorio';
        }else{
            if(strlen($this->password) < 6){
                static::$alertas['error'][] = 'El password debe tenar al menos 6 caracteres';
            }
            if($this->password !== $_POST['password2']){
                static::$alertas['error'][] = 'Los passwords no coinciden';
            }
        }

        return static::$alertas;
    }

    // verificar si el usuario ya esta registrado
    public function existeUsuario(){
        $query = "SELECT * FROM " . static::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = "El correo ya se encuentra registrado";
        }

        return $resultado;
    }


    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }


    public function passwordAndConfirmado($resultado){

        $verifyPass = password_verify($this->password,$resultado->password);
                    
        if($verifyPass){
            if($resultado->confirmado === '1'){
                return true;
            }else{
                Usuario::setAlerta('error','Tu cuenta no ha sido confirmada, revisar tu email con las instrucciones antes de intentar iniciar sesion');
            }
        }else{
            Usuario::setAlerta('error','Password incorrecto');
        }
    }


    // cambio de password

    public function validarNuevaPassword($args=[]) {

        if(!$args['passwordActual'] || !$args['passwordNueva'] || !$args['passwordConfirmar']){
            static::$alertas['error'][] = 'Todos los campos son obligatorios';     
        }else{
            if(strlen($args['passwordNueva']) < 6){
                static::$alertas['error'][] = 'El password debe tenar al menos 6 caracteres';
            }
            if($args['passwordNueva'] !== $args['passwordConfirmar']){
                static::$alertas['error'][] = 'Los passwords no coinciden';
            }
        }

        return static::$alertas;
    }

    public function verificarPassword($password){

        $verifyPass = password_verify($password, $this->password);

        return $verifyPass;
    }


}