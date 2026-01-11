<?php
require_once "config/routes.php";
require_once MODELO."modMinijuego.php";

class ConMinijuego {
    private $modelo;
    public $vista;

    public function __construct() {
        $this->modelo = new ModMinijuego();
    }

    /**
     * Muestra la pantalla principal con la lista de minijuegos y el historial
     */
    public function listarJuegos() {
        // Obtenemos todos los juegos para la lista principal
        $datos['todos'] = $this->modelo->obtenerTodos();
        
        // Obtenemos los IDs del historial de la cookie
        $historial = isset($_COOKIE['historial']) ? json_decode($_COOKIE['historial'], true) : [];
        
        // Obtenemos los datos completos de esos 3 IDs
        $datos['recientes'] = [];
        foreach ($historial as $id) {
            // Por cada ID consultamos al modelo para traer la información completa
            $datos['recientes'][] = $this->modelo->obtenerPorId($id);
        }

        $this->vista = "listar_juegos.php";
        return $datos;
    }

    /**
     * Gestiona la selección de un juego y actualiza la cookie
     */
    public function seleccionarJuego() {

        $id = $_GET['idMinijuego'];
        $datos = $this->modelo->obtenerPorId($id);

        // Actualizamos el historial de cookies
        $historial = isset($_COOKIE['historial']) ? json_decode($_COOKIE['historial'], true) : [];
        
        // Limpiamos duplicados, ponemos el primero y limitamos a 3
        $historial = array_diff($historial, [$id]);
        array_unshift($historial, $id);
        $historial = array_slice($historial, 0, 3);
        
        /*
        * Creamos la cookie con setcookie(nombre, valor, caducidad, ruta)
        * Para el valor uso json_encode para convertir el array a JSON
        */
        setcookie('historial', json_encode($historial), time() + (86400 * 30), "/"); 

        $this->vista = "pantalla_juego.php";
        return $datos;
    }
}
?>