<?php 

namespace Controllers;

use Model\Dia;
use Throwable;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;
use Model\EventoHorario;
use Model\EventosRegistros;
use Model\Regalo;

class   RegistroController {

    public static function crear(Router $router){
        
        if(!is_auth()){
            header('Location: /');
            return;
        }

        //Verificar si el usuario ya tiene plan
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        //Si el pase es el gratis o virtual-> redirigimos al boleto
        if(isset($registro) && ($registro->paquete_id === "3" )){//|| $registro->paquete_id === "2")){
            header('Location: /boleto?id=' . urlencode($registro->token)); //urlencode evit caracteres especiales        
        }

        //Si el pase es el presencial y ya se ha realizado pago (paquete_id seteado) entonces se redirige a selección de conferencias y regalo
        if(isset($registro) && $registro->paquete_id ==="1") {
            header('Location: /finalizar-registro/conferencias');
        }

        $router->render('registro/crear', [
            'titulo' => 'Finalizar registro'
        ]);

    }

    public static function gratis(Router $router){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /login');
                return;
            }

            //Verificar si el usuario ya tiene plan
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if(isset($registro) && $registro->paquete_id === "3"){
                header('Location: /boleto?id=' . urlencode($registro->token)); //urlencode evit caracteres especiales
                return;
            }


            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            //Crear registro
            $datos =  [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];

            $registro= new Registro($datos);

            $resultado= $registro->guardar();
            if($resultado){
                header('Location: /boleto?id=' . urlencode($registro->token)); //urlencode evit caracteres especiales
                return;
            }
        }

    }

    public static function boleto(Router $router){
        
        //validar url
        $id= $_GET['id'] ;

        if(!$id || !strlen($id) === 8){
            header('Location: /');
            return;
        }

        //Buscar en BBDD
        $registro= Registro::where('token', $id);
        if(!$registro){
            header('Location: /');
            return;
        }

        //LLenar las tablas de referencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);


        $router->render('registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);

    }


    public static function pagar(){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /login');
                return;
            }

            //Validar que POST no venga vacio
            if(empty($_POST)){
                echo json_encode([]);
                return;
            }

            //Crear registro
            $datos = $_POST;

            $datos['token']= substr(md5(uniqid(rand(), true)), 0, 8);
            $datos['usuario_id']= $_SESSION['id'];


            try {
                $registro= new Registro($datos);
                $resultado= $registro->guardar();
                echo json_encode($resultado);
                
                
            } catch(\Throwable $th){
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
            

        }

    }



    public static function conferencias(Router $router){
        

        if(!is_auth()){
            header('Location: /login');
            return;
        }
        
        //validar que el usuario plan presencial
        $usuario_id= $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);
        

        //Si el pase es el virtual o presencial tras haber completado registro -> redirigimos al boleto
        if(isset($registro) && ($registro->paquete_id === "2" 
        || (isset($registro->regalo_id) && $registro->paquete_id === "1" ))) {
            header('Location: /boleto?id=' . urlencode($registro->token)); //urlencode evit caracteres especiales 
            return;       
        }
        
       /* //Redireccionar a boleto virtual en caso de haber finalizado su registro y si el pase no es gratis
        if(isset($registro->regalo_id) && $registro->paquete_id === "1"){
            header('Location: /boleto?id=' . urlencode($registro->token)); //urlencode evit caracteres especiales
            return;
        }*/
        //Si el pase es gratis, redirimos al menu principal
        else if(isset($registro) && $registro->paquete_id === "3"){
            header("Location: /");
            return;
        }


        $eventos = Evento::ordenar('hora_id', 'ASC');


        $eventos_formateados = [];
        foreach($eventos as $evento){
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
            
            if($evento->dia_id === "1" && $evento->categoria_id ==="1"){
                $eventos_formateados['conferencias_v'][]= $evento;
            }
            else if($evento->dia_id === "2" && $evento->categoria_id ==="1"){
                $eventos_formateados['conferencias_s'][]= $evento;
            }
            else if($evento->dia_id === "1" && $evento->categoria_id ==="2"){
                $eventos_formateados['workshops_v'][]= $evento;
            }
            else if($evento->dia_id === "2" && $evento->categoria_id ==="2"){
                $eventos_formateados['workshops_s'][]= $evento;
            }
        }

        $regalos= Regalo::all('ASC');

        //manejando el registro mediante $_POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            //Revisar que el usuario esta autenticado
            if(!is_auth()){
                header('Location: /login');
                return;
            }
            
            //Separar eventos del array
            $eventos = explode(',', $_POST['eventos']);
            if(empty($eventos)){
                echo json_encode(['resultado' => false]);
                return;
            }

            //Obtener el registro de usuario
            $registro= Registro::where('usuario_id', $_SESSION['id']);

            if(!isset($registro) || $registro->paquete_id !=="1"){
                echo json_encode(['resultado' => false]);
                return;
            }

            $eventos_array=[];
            //validar la disponibilidad de los eventos seleccionados en el momento de darle al boton de registrar
            foreach ($eventos as $evento_id ) {
                $evento= Evento::find($evento_id);

                //Comprobar que el evento existe
                if(!isset($evento) || $evento->disponibles === "0"){
                    echo json_encode(['resultado' => false]);
                    return;
                }

                $eventos_array []= $evento;

            }

            //Se actualiza el valor de disponibles a partir del array en memoria
            foreach ($eventos_array as $evento) {
                $evento->disponibles -=1;
                $evento->guardar();
                
                
                //Almacenar el registro
                $datos= [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];
                $registro_usuario = new EventosRegistros($datos);
                $registro_usuario->guardar();
                
            }
                //Almacenar el regalo
                $registro->sincronizar(['regalo_id' => $_POST['regalo_id'] ]);
                $resultado= $registro->guardar();

                if($resultado){
                    echo json_encode([
                        'resultado' => $resultado,
                        'token' => $registro->token
                    ]);
                } else {
                    echo json_encode(['resultado' => false]);
                }
    

                return;
        }

        $router->render('registro/conferencias', [
            'titulo' => 'Elige Workshops y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos
        ]);

    }
}