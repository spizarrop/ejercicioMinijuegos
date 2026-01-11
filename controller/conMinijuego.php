<?php
require_once "config/routes.php";
require_once MODELO."modMinijuego.php";

class ConMinijuego {
    private $modelo;
    public $vista;

    public function __construct() {
        $this->modelo = new ModMinijuego();
    }

    public function listar() {
        // Obtenemos todos los juegos de la base de datos
        $datos['todos'] = $this->modelo->obtenerTodos();
        
        /* 
        * Leemos la cookie llamada 'historial'
        * Usamos json_decode para convertir la cookie de JSON a un array
        * Si la cookie no existe inicializamos historial como un array vacio 
        */
        $historial = isset($_COOKIE['historial']) ? json_decode($_COOKIE['historial'], true) : [];
        
        // Preparamos un hueco en el array de datos para los juegos recientes
        $datos['recientes'] = [];
        
        // Recorremos los IDs guardados en la cookie
        foreach ($historial as $id) {
            // Por cada ID, consultamos al modelo para traer la información completa
            $datos['recientes'][] = $this->modelo->obtenerPorId($id);
        }

        // Definimos la vista y devolvemos el array con todos los minijuegos y los recientes
        $this->vista = "listar_juegos.php";
        return $datos;
    }

    public function ver() {
        // Obtenemos los datos del juego seleccionado
        $id = $_GET['idMinijuego'];
        $datos = $this->modelo->obtenerPorId($id);

        // Recuperamos el historial actual de la cookie
        $historial = isset($_COOKIE['historial']) ? json_decode($_COOKIE['historial'], true) : [];
        
        // Buscamos si el ID del juego actual ya está en el historial.
        if (($key = array_search($id, $historial)) !== false) {
            // Si ya estaba, lo borramos de su posición antigua para que no se repita
            unset($historial[$key]);
        }
        
        // Añadimos el ID del juego actual al PRINCIPIO del array
        array_unshift($historial, $id); 
        
        // Cortamos el array para quedarnos solo con los primeros 3 elementos
        $historial = array_slice($historial, 0, 3); 
        
        /*
        * setcookie(nombre, valor_texto, caducidad, ruta)
        * Usamos json_encode para convertir nuestro array de IDs en un string de texto
        */
        setcookie(
            'historial', 
            json_encode($historial), 
            time() + (86400 * 30),
            "/"
        ); 

        $this->vista = "pantalla_juego.php";
        return $datos;
    }
}
?>