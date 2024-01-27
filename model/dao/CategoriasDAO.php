<?php
require_once 'config/Conexion.php';

class CategoriasDAO {
    private $con;

    public function __construct() {
        $this->con = Conexion::getConexion();
    }
    public function selectCat() {
        try {
            // Preparar la consulta SQL utilizando parámetros nombrados
            $sql = "SELECT * FROM categoria WHERE cat_estado = :estado";
            $stmt = $this->con->prepare($sql);
            // Asignar valores a los parámetros
            $estado = 1; // Suponiendo que 1 significa estado activo
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
            // Ejecutar la consulta preparada
            $stmt->execute();
            // Obtener los resultados como objetos
            $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
            // Retornar los resultados
            return $resultados;
        } catch (PDOException $e) {
            // Manejar excepciones si ocurre un error en la consulta
            throw new Exception("Error al seleccionar categorías: " . $e->getMessage());
        }
    }
    

    public function selectAllCategorias($parametro = null) {
        try {
            $sql = "SELECT * FROM categoria";
            // Agregar condición de búsqueda si se proporciona un parámetro
            if (!empty($parametro)) {
                $sql .= " AND (cat_nombre LIKE :parametro OR cat_descripcion LIKE :parametro)";
            } 
            $stmt = $this->con->prepare($sql);
            // Asignar valores al parámetro solo si se proporciona
            if (!empty($parametro)) {
                $conlike = '%' . $parametro . '%';
                $stmt->bindParam(':parametro', $conlike, PDO::PARAM_STR);
            }
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $resultados;
        } catch (PDOException $e) {
            // En caso de error, imprime el mensaje de error y maneja la excepción
            echo "Error en la consulta: " . $e->getMessage();
            // Puedes registrar el error, redirigir a una página de error, etc.
            return false;
        }
    }
    public function selectOne($id) {
        // Consulta SQL para seleccionar una categoría por su ID
        $sql = "SELECT * FROM categoria WHERE cat_id = :id";
        // Preparar la consulta SQL
        $stmt = $this->con->prepare($sql);        
        // Datos a ser utilizados en la consulta
        $data = ['id' => $id];
        // Ejecutar la consulta
        $stmt->execute($data);
        // Recuperar los datos
        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
        // Retornar la categoría
        return $categoria;
    }
    
    public function insert($cat) {
        try {
            // Iniciar una transacción
            $this->con->beginTransaction();
            // Preparar la consulta SQL
            $sql = "INSERT INTO categoria (cat_nombre, cat_descripcion, cat_estado, cat_usuarioActualizacion, cat_fechaActualizacion) 
            VALUES (:nom, :desc, :estado, :usu, :fecha)";
            $sentencia = $this->con->prepare($sql);
            // Crear un array asociativo con los valores a insertar
            $data = array(
                ':nom' => $cat->getNombre(),
                ':desc' => $cat->getDescripcion(),
                ':estado' => $cat->getEstado(),
                ':usu' => $cat->getUsuario(),
                ':fecha' => $cat->getFechaActualizacion()
            );
            // Ejecutar la consulta
            $sentencia->execute($data);
            // Obtener el ID de la última fila insertada
            $lastId = $this->con->lastInsertId();
            // Verificar si se insertó correctamente
            if ($lastId <= 0) {
                throw new Exception("No se pudo insertar la nueva categoría.");
            }
            // Si llegamos aquí, significa que la inserción fue exitosa
            // Cometer la transacción
            $this->con->commit();
            return true;
        } catch (Exception $e) {
            // Si hay un error, deshacer la transacción
            $this->con->rollback();
            echo $e->getMessage();
            return false;
        }
    }
    
    public function update($cat) {
        try {
            // Preparar la consulta SQL
            $sql = "UPDATE categoria 
                    SET cat_nombre=:nom, cat_descripcion=:desc, cat_estado=:estado, cat_usuarioActualizacion=:usu, cat_fechaActualizacion=:fecha 
                    WHERE cat_id=:id";
            $sentencia = $this->con->prepare($sql);
            // Formatear la fecha como una cadena
            $fecha = $cat->getFechaActualizacion()->format('Y-m-d H:i:s');
            // Crear un array asociativo con los valores a actualizar
            $data = array(
                ':nom' => $cat->getNombre(),
                ':desc' => $cat->getDescripcion(),
                ':estado' => $cat->getEstado(),
                ':usu' => $cat->getUsuario(),
                ':fecha' => $fecha, // Usar la fecha formateada
                ':id' => $cat->getId()
            );
            // Ejecutar la consulta
            $sentencia->execute($data);
            // Verificar si se actualizó correctamente
            if ($sentencia->rowCount() <= 0) {
                return false; // No se actualizó ninguna fila
            }
            return true; // Actualización exitosa
        } catch (Exception $e) {
            // Manejar cualquier excepción y retornar falso
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($categoria) {
        try {
            // Preparar la consulta SQL
            $sql = "DELETE FROM categoria WHERE cat_id = :id";
            $sentencia = $this->con->prepare($sql);
            // Bind de parámetros
            $sentencia->bindParam(':id', $categoria->getId(), PDO::PARAM_INT);
            // Ejecutar la consulta
            $sentencia->execute();
            // Verificar si se eliminó correctamente
            if ($sentencia->rowCount() <= 0) {
                return false; // No se eliminó ninguna fila
            }
            return true; // Eliminación exitosa
        } catch (Exception $e) {
            // Manejar cualquier excepción y retornar falso
            echo $e->getMessage();
            return false;
        }
    }
}