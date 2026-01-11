<?php
require_once "config/conexionDB.php";

class ModMinijuego {
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli(SERVER, USER, PASS, DB);
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM minijuegos ORDER BY nombre";
        $resultado = $this->conexion->query($sql);
        $datos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }
        return $datos;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM minijuegos WHERE idMinijuego = $id";
        $resultado = $this->conexion->query($sql);
        return $resultado->fetch_assoc();
    }
}
?>