<?php

namespace Controllers;

use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {
    public static function index(Router $router){
        $ponentes = Ponente::all();

        if(!is_admin()){
            header('Location: /login');
        }


        $router->render ('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes
        ]);
    }

    public static function crear(Router $router){
        if(!is_admin()){
            header('Location: /login');
        }
        $alertas=[];

        $ponente= new Ponente;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $ponente->sincronizar($_POST);
            
            //Leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])){
                
                $carpeta_imagenes = '../public/img/speakers';
                //Crear carpeta si no existe 
                if(!is_dir($carpeta_imagenes)){
                    mkdir($carpeta_imagenes, 0777, true);
                }
                
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);
                
                $nombre_imagen= md5(uniqid (rand(), true));
                
                $_POST['imagen'] = $nombre_imagen;
                
            }
            $_POST['redes'] = json_encode ($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);

            //Validar
            $alertas = $ponente->validar();

            //Guardar registro
            if(empty($alertas)){
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

                //Guardar en BBDD
                $resultado = $ponente->guardar();

                if($resultado){
                    header('Location : /admin/ponentes');
                }
            }
        }

        $router->render ('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }


    //Lógica para editar los ponentes
    public static function editar(Router $router){
        if(!is_admin()){
            header('Location: /login');
        }

        $alertas=[];

        $id= $_GET['id'];
        $id= filter_var($id, FILTER_VALIDATE_INT);

        //Filtro seguridad: id siempre es un int
        if(!$id){
            header('Location: /admin/ponentes');
        }

        $ponente = Ponente::find($id);

        if (!$ponente) {
            header('Location: /admin/ponentes');
        }

       //Creamos propiedad auxiliar
        $ponente->imagen_actual= $ponente->imagen;


        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Proteger POST
            if(!is_admin()){
                header('Location: /login');
               }

            //Leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])){
    
            $carpeta_imagenes = '../public/img/speakers';
            //Crear carpeta si no existe 
            if(!is_dir($carpeta_imagenes)){
                mkdir($carpeta_imagenes, 0777, true);
            }
            
            $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
            $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);
            
            $nombre_imagen= md5(uniqid (rand(), true));
            
            $_POST['imagen'] = $nombre_imagen;
            
            }else {
                $_POST['imagen'] = $ponente->imagen_actual;
            }
            $_POST['redes'] = json_encode ($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);
            
            $alertas=$ponente->validar();

            if(empty($alertas)) {
                if(isset($nombre_imagen)){
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }

                $resultado= $ponente->guardar();
                if($resultado){
                    header('Location: /admin/ponentes');
                }
            }
        }

        $router->render ('admin/ponentes/editar', [
            'titulo' => 'Actualizar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }


    //Lógica para eliminar los ponentes
    public static function eliminar(){
        if(!is_admin()){
            header('Location: /login');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id= $_POST['id'];

            $ponente= Ponente::find($id);
            if(!isset($ponente)){
                header('Location: /admin/ponentes');
            }
            $resultado= $ponente->eliminar($id);

            if($resultado){
                header('Location: /admin/ponentes');
            }
        }
    }
       
}