<?php
require_once 'model/dao/ProductosDAO.php';
require_once 'model/dao/CategoriasDAO.php';
require_once 'model/dto/Producto.php';

class ProductosController {
    private $model;

    public function __construct() {
        $this->model = new ProductosDAO();
        $this->categoriasDAO = new CategoriasDAO();
    }
    
    // funciones del controlador
    public function index() { 
        $resultados = $this->model->selectAll("");
        $titulo = "Listado de productos";
        require_once VPRODUCTOS . 'list.php';
    }

    public function search() {
        try {
            // Leer parámetro de búsqueda enviado por POST
            $parametro = (!empty($_POST["b"])) ? htmlentities($_POST["b"]) : "";
            // Obtener resultados de la búsqueda desde el modelo
            $resultados = $this->model->selectAll($parametro);
            // Comunicarnos con la vista
            $titulo = "Buscar productos";
            require_once VPRODUCTOS . 'list.php';
        } catch (Exception $e) {
            // Manejar la excepción según tus necesidades
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['mensaje'] = "Error al buscar productos: " . $e->getMessage();
            $_SESSION['color'] = "danger";
            header('Location: index.php?c=productos&f=index');
            exit;
        }
    }
    

    public function view_new() {
        $modeloCat = new CategoriasDAO();
        $categorias = $modeloCat->selectCat();
        // Comunicarse con la vista y pasar los datos obtenidos
        $titulo = "Nuevo producto";
        require_once VPRODUCTOS . 'nuevo.php';
    }

    public function new() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Insertar el nuevo producto
            if (empty($_POST['nombre'])) {
                header('Location:index.php?c=Productos&f=index');
                exit;
            }
            $prod = new Producto(); // DTO
            // Lectura de parámetros
            $prod->setNombre(htmlentities($_POST['nombre']));
            $prod->setPrecio(htmlentities($_POST['precio']));
            $prod->setIdCategoria(htmlentities($_POST['categoria']));
            $estado = (isset($_POST['estado'])) ? 1 : 0;
            $prod->setEstado($estado);
            // Obtener el nombre de usuario de la sesión
            session_start();
            $nombreUsuario = $_SESSION['usuario'];
            $prod->setUsuario($nombreUsuario);
            $fechaActual = new DateTime('NOW');
            $prod->setFechaActualizacion($fechaActual->format('Y-m-d H:i:s'));
            // Comunicar con el modelo para insertar el nuevo producto
            $exito = $this->model->insert($prod);
            $msj = 'Producto guardado exitosamente';
            $color = 'primary';
            if (!$exito) {
                $msj = 'No se pudo realizar el guardado.';
                $color = 'danger';
            }
            // Iniciar sesión si aún no ha iniciado sesión
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['mensaje'] = $msj;
            $_SESSION['color'] = $color;
            // Redireccionar a la lista de productos
            header('Location:index.php?c=Productos&f=index');
            exit;
        }
    }
    

    public function delete() {
        try {
            // Iniciar la sesión si aún no ha iniciado sesión
            if (!isset($_SESSION)) {
                session_start();
            }
            // Verificar si el usuario tiene la sesión iniciada
            if (!isset($_SESSION['usuario'])) {
                throw new Exception("Debe iniciar sesión para eliminar un producto.");
            }
            // Leer parámetros
            $id = isset($_REQUEST['id']) ? htmlentities($_REQUEST['id']) : null;
            // Verificar si se proporciona un ID válido
            if (!$id) {
                throw new Exception("ID de producto no proporcionado.");
            }
            // Crear un objeto de producto con el ID proporcionado
            $prod = new Producto();
            $prod->setId($id);
            $prod->setUsuario($_SESSION['usuario']);
            $fechaActual = new DateTime('NOW');
            $prod->setFechaActualizacion($fechaActual->format('Y-m-d H:i:s'));
            // Comunicarse con el modelo para eliminar el producto
            $exito = $this->model->delete($prod);
            // Verificar si la eliminación fue exitosa
            if ($exito) {
                $_SESSION['mensaje'] = 'Producto eliminado exitosamente';
                $_SESSION['color'] = 'success';
            } else {
                $_SESSION['mensaje'] = 'No se pudo eliminar el producto';
                $_SESSION['color'] = 'danger';
            }
            // Redirigir a la página de index
            header('Location: index.php?c=productos&f=index');
            exit;
        } catch (Exception $e) {
            // Manejar la excepción y mostrar un mensaje de error
            $_SESSION['mensaje'] = 'Error: ' . $e->getMessage();
            $_SESSION['color'] = 'danger';
            // Redirigir a la página de index
            header('Location: index.php?c=productos&f=index');
            exit;
        }
    }
    
    public function view_edit() {
        try {
            // Obtener el ID del producto a editar desde $_GET
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            // Verificar si se proporciona un ID válido
            if (!$id) {
                throw new Exception("ID de producto no proporcionado.");
            }
            // Obtener los datos del producto con el ID proporcionado
            $prod = $this->model->selectOne($id);
            // Comunicarse con el modelo de categorías para obtener todas las categorías
            $modeloCat = new CategoriasDAO();
            $categorias = $modeloCat->selectCat();
            // Comunicarse con la vista de edición y pasar las variables
            $titulo = "Editar producto";
            require_once VPRODUCTOS . 'edit.php';
        } catch (Exception $e) {
            // Manejar la excepción y mostrar un mensaje de error
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['mensaje'] = "Error al cargar el producto para editar: " . $e->getMessage();
            $_SESSION['color'] = "danger";
            header('Location: index.php?c=productos&f=index');
            exit;
        }
    }

    public function edit() {
        try {
            session_start(); // Iniciar la sesión
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtener los datos del formulario
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $precio = $_POST['precio'];
                $categoria = $_POST['categoria'];
                $estado = $_POST['estado'];
                
                // Crear un objeto Producto con los datos actualizados
                $prod = new Producto();
                $prod->setId($id);
                $prod->setNombre($nombre);
                $prod->setPrecio($precio);
                $prod->setIdCategoria($categoria);
                $prod->setEstado($estado);
                $prod->setUsuario($_SESSION['usuario']);
                $fechaActual = new DateTime('NOW');
                $prod->setFechaActualizacion($fechaActual->format('Y-m-d H:i:s'));
                
                // Llamar al método update en el DAO para actualizar el producto
                $resultado = $this->model->update($prod);
                
                // Verificar si se actualizó correctamente
                if ($resultado) {
                    $_SESSION['mensaje'] = 'Producto actualizado correctamente';
                    $_SESSION['color'] = 'success';
                } else {
                    $_SESSION['mensaje'] = 'No se pudo actualizar el producto';
                    $_SESSION['color'] = 'danger';
                }
                
                // Redirigir a la página de index
                header('Location: index.php?c=productos&f=index');
                exit;
            } else {
                // Obtener el ID del producto a editar desde la URL
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                
                // Llamar al método selectOne en el DAO para obtener el producto
                $prod = $this->model->selectOne($id);
                
                // Comunicar con el modelo de categorías para obtener todas las categorías
                $modeloCat = new CategoriasDAO();
                $categorias = $modeloCat->selectAll();
                
                // Renderizar la vista de edición y pasarle el producto y las categorías
                $titulo = "Editar producto";
                require_once VPRODUCTOS . 'edit.php';
            }
        } catch (Exception $e) {
            // Manejar la excepción y mostrar un mensaje de error
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['mensaje'] = 'Error al actualizar el producto: ' . $e->getMessage();
            $_SESSION['color'] = 'danger';
            
            // Redirigir a la página de index
            header('Location: index.php?c=productos&f=index');
            exit;
        }
    }
    public function cerrarSesion() {
        // Eliminar la variable de sesión "usuario"
        unset($_SESSION['usuario']);
    
        // Eliminar las cookies
        setcookie("usuario_id", "", time() - 3600, "/");
        setcookie("rol", "", time() - 3600, "/");
    
        // Redirigir al usuario a la página de inicio de sesión
        header('Location: index.php?c=usuario&f=login');
        exit;
      }
    
}
