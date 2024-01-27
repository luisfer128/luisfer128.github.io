<?php
    require_once 'config/config.php';

    // Leer parámetros
    $controlador = (!empty($_REQUEST['c'])) ? htmlentities($_REQUEST['c']) : CONTROLADOR_PRINCIPAL;
    // Formatear el nombre del controlador
    $controlador = ucwords(strtolower($controlador)) . "Controller";
    // Obtener el nombre de la función
    $funcion = (!empty($_REQUEST['f'])) ? htmlentities($_REQUEST['f']) : FUNCION_PRINCIPAL;
    // Incluir el archivo del controlador
    require_once 'controller/' . $controlador . '.php';
    // Crear una instancia del controlador
    $cont = new $controlador();
    // Verificar si la función existe en el controlador
    if (method_exists($cont, $funcion)) {
        // Llamar a la función del controlador
        $cont->$funcion();
    } else {
        // Manejar el caso en que la función no exista
        echo "La función '$funcion' no existe en el controlador '$controlador'.";
    }
?>
