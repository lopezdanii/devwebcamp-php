<?php

namespace Controllers;

use Model\Evento;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class DashboardController {
    public static function index(Router $router){

        if(!is_admin()){
            header('Location: /login');
        }
        //Obtener ultimos registrados
        $registros= Registro::get(5);
        foreach ($registros as $registro) {
            $registro->usuario = Usuario::find($registro->usuario_id);
        }

        //calcular ingresos
        $virtuales= Registro::count('paquete_id', 2);
        $presenciales= Registro::count('paquete_id', 1);
        //Se calculan los importes teniendo en cuenta el 21% IVA
        $ingresos = ($virtuales * (35*0.79)) + ($presenciales * (70*0.79));

        //Obtener eventos con meas y menos plazas disponibles
        $eventosMasDisponibles = Evento::ordenarLimit('disponibles', 'DESC', 5);
        $eventosMenosDisponibles = Evento::ordenarLimit('disponibles', 'ASC', 5);
                

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de administración',
            'registros' => $registros,
            'ingresos' => $ingresos,
            'eventos_mas_disponibles' => $eventosMasDisponibles,
            'eventos_menos_disponibles' => $eventosMenosDisponibles
        ]);
    }

}