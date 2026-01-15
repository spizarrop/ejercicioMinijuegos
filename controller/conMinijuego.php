<?php
require_once "config/routes.php";
require_once MODELO."modMinijuego.php";
require_once "lib/fpdf186/fpdf.php";

class ConMinijuego extends FPDF {
    private $modelo;
    public $vista;

    public function __construct() {
        parent::__construct();
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

    /**
     * Genera un archivo PDF con la lista de minijuegos
     */
    function Header() {
        /* Para establecer una cabecera en mi PDF, esta se repetirá en todas las páginas */
        $this->SetFont('Arial','B',18);
        $this->Cell(200,10, 'Listado de minijuegos disponibles');
        $this->Ln();
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->Cell(100,10, 'Nombre');
        $this->Cell(150,10, 'URL');
        $this->Ln();
        $this->Line(10,40,200,40);
    }
    
    function Footer(){
        /* Para establecer un pie de página en mi PDF, esta se repetirá en todas las páginas */
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo()));
    }

    public function generarPDF() {
        // Obtenemos todos los juegos para la lista principal
        $datos['todos'] = $this->modelo->obtenerTodos();

        // Instanciamos la clase
        $pdf = new ConMinijuego();
        // Agregamos una página
        $pdf->AddPage();
        // Le ponemos un título al PDF
        $pdf->SetTitle('Listado de juegos PDF');
        // Añadimos el contenido del PDF
        $pdf->SetFont('Arial','',12);
        foreach($datos['todos'] as $dato) {
            $pdf->Cell(100,10, utf8_decode($dato['nombre']));
            $pdf->Cell(150,10, utf8_decode($dato['url']));
            $pdf->Ln();
        }
        // Formamos el PDF
        $pdf->Output();
    }
    
}
?>