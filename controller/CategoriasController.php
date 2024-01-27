<?php
require_once 'model/dao/CategoriasDAO.php';
require_once 'model/dto/Categoria.php';

class CategoriasController {

    private $model;
    
    public function __construct() {
        $this->model = new CategoriasDAO();
    }

    // funciones del controlador
    public function index() { 
        // Comunicarse con el modelo para obtener datos de categorías
        $resultado = $this->model->selectAllCategorias("");
        // var_dump($resultado);
        // Comunicarnos a la vista
        $titulo = "Listado de Categorías"; 
        require_once VCATEGORIAS . 'list.php';
    }

    public function buscar() {
        try {
            // Lectura de parámetros enviados
            $parametro = (!empty($_POST["b"])) ? htmlentities($_POST["b"]) : "";
            // Comunicarse con el modelo para obtener datos de categorías
            $resultado = $this->model->selectAllCategorias($parametro);
            // Comunicarnos a la vista
            $titulo = "Buscar categorías";
            require_once VCATEGORIAS . 'list.php';
        } catch (Exception $e) {
            // Manejar la excepción según tus necesidades
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['mensaje'] = "Error al buscar categorías: " . $e->getMessage();
            $_SESSION['color'] = "danger";
            header('Location: index.php?c=categorias&f=index');
            exit;
        }
    }

    // Mostrar formulario para agregar una nueva categoría
    public function ver_nuevo() {
        $titulo = "Nueva categoría";
        require_once VCATEGORIAS . 'nuevo.php';
    }

    public function agregar_nuevo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Insertar la nueva categoría
            if (empty($_POST['nombre'])) {
                header('Location: index.php?c=categorias&f=index');
                exit;
            }
            $nuevaCategoria = new Categoria(); // DTO
            // Lectura de parámetros
            $nuevaCategoria->setNombre(htmlentities($_POST['nombre']));
            $nuevaCategoria->setDescripcion(htmlentities($_POST['descripcion']));
            $nuevaCategoria->setEstado(htmlentities($_POST['estado']));
            // Obtener el nombre de usuario de la sesión
            session_start();
            $nombreUsuario = $_SESSION['usuario'];
            // Asignar el nombre de usuario a la categoría
            $nuevaCategoria->setUsuario($nombreUsuario);
            $fechaActual = new DateTime('NOW');
            $nuevaCategoria->setFechaActualizacion($fechaActual->format('Y-m-d H:i:s'));
            // Comunicar con el modelo para insertar la nueva categoría
            $exito = $this->model->insert($nuevaCategoria);
            $mensaje = 'Categoría guardada exitosamente';
            $color = 'primary';
            if (!$exito) {
                $mensaje = 'No se pudo realizar el guardado.';
                $color = 'danger';
            }
            // Iniciar sesión si aún no inicia sesión
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['mensaje'] = $mensaje;
            $_SESSION['color'] = $color;
            // Redireccionar a la lista de categorías
            header('Location: index.php?c=categorias&f=index');
            exit;
        }
    }
    // Mostrar formulario para editar una nueva categoría
    public function ver_edicion() {
        try {
            // Obtener el ID de la categoría a editar desde $_GET
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            // Verificar si se proporciona un ID válido
            if (!$id) {
                throw new Exception("ID de categoría no proporcionado.");
            }
            // Obtener los datos de la categoría con el ID proporcionado
            $categoria = $this->model->selectOne($id);
            // Comprobar si se encontró la categoría
            if (!$categoria) {
                throw new Exception("No se encontró la categoría con el ID proporcionado.");
            }
            // Comunicarse con la vista de edición y pasar la variable $categoria
            $titulo = "Editar Categoría";
            require_once VCATEGORIAS . 'editar.php';
        } catch (Exception $e) {
            // Manejar la excepción y mostrar un mensaje de error
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['mensaje'] = "Error al cargar la categoría para editar: " . $e->getMessage();
            $_SESSION['color'] = "danger";
            header('Location: index.php?c=categorias&f=index');
            exit;
        }
    }
    // Leer datos del formulario de editar categoria
    //y lo actualiza en la bdd (llamando al modelo)
    public function editar() {
        try {
            session_start(); // Iniciar la sesión
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtener los datos del formulario
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $estado = $_POST['estado'];
                // Obtener la fecha y hora actual
                $fechaActual = new DateTime('NOW');
                // Crear un objeto Categoria con los datos actualizados
                $categoria = new Categoria();
                $categoria->setId($id);
                $categoria->setNombre($nombre);
                $categoria->setDescripcion($descripcion);
                $categoria->setEstado($estado);
                $categoria->setUsuario($_SESSION['usuario']);
                $categoria->setFechaActualizacion($fechaActual);
                // Llamar al método update en el DAO para actualizar la categoría
                $dao = new CategoriasDAO();
                $resultado = $dao->update($categoria);
                // Verificar si se actualizó correctamente
                if ($resultado) {
                    $_SESSION['mensaje'] = 'Categoría actualizada correctamente';
                    $_SESSION['color'] = 'success';
                } else {
                    $_SESSION['mensaje'] = 'No se pudo actualizar la categoría';
                    $_SESSION['color'] = 'danger';
                }
                // Redirigir a la página de index
                header('Location: index.php?c=categorias&f=index');
                exit;
            } else {
                // Obtener el ID de la categoría a editar desde la URL
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                // Llamar al método selectOne en el DAO para obtener la categoría
                $dao = new CategoriasDAO();
                $categoria = $dao->selectOne($id);
                // Renderizar la vista de edición y pasarle la categoría
                require_once VCATEGORIAS . 'categorias.editar.php';
            }
        } catch (Exception $e) {
            // Manejar la excepción y mostrar un mensaje de error
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['mensaje'] = 'Error al actualizar la categoría: ' . $e->getMessage();
            $_SESSION['color'] = 'danger';
            // Redirigir a la página de index
            header('Location: index.php?c=categorias&f=index');
            exit;
        }
    }
    public function eliminar() {
        try {
            session_start(); // Iniciar la sesión
            // Verificar si el usuario tiene la sesión iniciada
            if (!isset($_SESSION['usuario'])) {
                throw new Exception("Debe iniciar sesión para eliminar una categoría.");
            }
            // Leer parámetros
            $id = isset($_REQUEST['id']) ? htmlentities($_REQUEST['id']) : null;
            // Verificar si se proporciona un ID válido
            if (!$id) {
                throw new Exception("ID de categoría no proporcionado.");
            }
            // Crear un objeto de categoría con el ID proporcionado
            $categoria = new Categoria();
            $categoria->setId($id);
            // Comunicarse con el modelo para eliminar la categoría
            $exito = $this->model->delete($categoria);
            // Verificar si la eliminación fue exitosa
            if ($exito) {
                $_SESSION['mensaje'] = 'Categoría eliminada exitosamente';
                $_SESSION['color'] = 'success';
            } else {
                $_SESSION['mensaje'] = 'No se pudo eliminar la categoría';
                $_SESSION['color'] = 'danger';
            }
            // Redirigir a la página de index
            header('Location: index.php?c=categorias&f=index');
            exit;
        } catch (Exception $e) {
            // Manejar la excepción y mostrar un mensaje de error
            $_SESSION['mensaje'] = 'Error: ' . $e->getMessage();
            $_SESSION['tipo_mensaje'] = 'danger';
            
            // Redirigir a la página de index
            header('Location: index.php?c=categorias&f=index');
            exit;
        }
    }
}