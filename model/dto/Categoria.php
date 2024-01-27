<?php

class Categoria{
    private $id, $nombre, $descripcion, $estado, $usuario, $fechaActualizacion;

    public function __construct() {
        // Inicializar propiedades si es necesario
        $this->id = 0;
        $this->nombre = '';
        $this->descripcion = '';
        $this->estado = 0;
        $this->usuario = '';
        $this->fechaActualizacion = null;
    }
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getEstado() {
        return $this->estado;
    }
    function getUsuario() {
        return $this->usuario;
    }

    function getFechaActualizacion() {
        return $this->fechaActualizacion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setFechaActualizacion($fechaActualizacion) {
        $this->fechaActualizacion = $fechaActualizacion;
    }
    
    // Methods get y set parametrizados
    public function __set($nombre, $valor) {
        // Comprobar si la propiedad existe
        if (property_exists('Categoria', $nombre)) {
            $this->$nombre = $valor;
        } else {
            echo $nombre . " No existe.";
        }
    }

    public function __get($nombre) {
        // Comprobar si la propiedad existe
        if (property_exists('Categoria', $nombre)) {
            return $this->$nombre;
        }
        // Retorna null si no existe
        return null;
    }
}

?>