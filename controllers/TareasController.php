<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareasController{

    public static function index(){

        $proyectoId = $_GET['id'];

        if(!$proyectoId){
            header('Location: /dashboard');
        }
        
        $proyecto = Proyecto::where('url',$proyectoId);
        
        session_start();

        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){          
            header('Location: /dashboard');
        }

        $tareas = Tarea::whereAll('proyectoId',$proyecto->id);
            
        echo json_encode(['tareas' => $tareas]);
        

    }
    
    public static function crear(){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            session_start();

            $proyecto = Proyecto::where('url',$_POST['proyectoId']);

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']){
                $respuesta = [
                    'tipo' => 'error'
                ];

                echo json_encode($respuesta);
                return;
            }

            // si el proyecto existe y pertenece al usuario entonces:

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();

            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'proyectoId' => $proyecto->id
            ];
            echo json_encode($respuesta);
        }
    }

    public static function actualizar(){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            session_start();
            
            $proyecto = Proyecto::where('id',$_POST['proyectoId']);

            if($proyecto && $proyecto->propietarioId === $_SESSION['id']){

                $tarea = Tarea::where('id',$_POST['tareaId']);

                if($tarea){
                    $tarea->estado = $_POST['estado'];
                    $tarea->nombre = $_POST['nombre'];

                    
                    $tarea->guardar();

                    $respuesta = [
                         'tipo' => 'success' , 
                         'mensaje'=> 'Actualizado'
                    ];
                    echo json_encode($respuesta);
                }
            }else{
                
                $respuesta = [
                    'tipo' => 'error' , 
                    'mensaje'=> 'Error al intentar actualizar'
               ];
               echo json_encode($respuesta);            
            }
        }
    }

    public static function eliminar(){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            session_start();
            
            $proyecto = Proyecto::where('url',$_POST['proyectoUrl']);

            if($proyecto && $proyecto->propietarioId === $_SESSION['id']){

                $tarea = Tarea::where('id',$_POST['tareaId']);
                if($tarea){

                    $tarea->eliminar();

                    $respuesta = [
                         'tipo' => 'success' , 
                         'mensaje'=> 'Tarea borrada'
                    ];
                    echo json_encode($respuesta);
                }
            }else{
                
                $respuesta = [
                    'tipo' => 'error' , 
                    'mensaje'=> 'Error al intentar borrar la tarea'
               ];
               echo json_encode($respuesta);            
            }
        }
    }
}