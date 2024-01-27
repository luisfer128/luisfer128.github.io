<?php
// dto data transfer object
class Producto {
    //properties
    private $id, $nombre, $estado, $precio, 
    $idCategoria, $usuario, $fechaActualizacion;

    public function __construct() {
        // Inicializar propiedades si es necesario
        $this->id = 0;
        $this->nombre = '';
        $this->estado = 0;
        $this->precio = 0.0;
        $this->idCategoria = 0;
        $this->usuario = '';
        $this->fechaActualizacion = null;
    }

   function getId() {
        return $this->id;
    }

   
    function getNombre() {
        return $this->nombre;
    }


    function getEstado() {
        return $this->estado;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getIdCategoria() {
        return $this->idCategoria;
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

  
    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setFechaActualizacion($fechaActualizacion) {
        $this->fechaActualizacion = $fechaActualizacion;
    }
    

    public function __set($nombre, $valor) {
        // Comprobar si la propiedad existe
        if (property_exists('Producto', $nombre)) {
            $this->$nombre = $valor;
        } else {
            echo $nombre . " No existe.";
        }
    }

    public function __get($nombre) {
        // Comprobar si la propiedad existe
        if (property_exists('Producto', $nombre)) {
            return $this->$nombre;
        }
        // Retorna null si no existe
        return null;
    }
}
?>
