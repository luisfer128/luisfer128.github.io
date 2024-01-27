<?php
if (!isset($_SESSION)) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario']) && time() - $_SESSION['login_time'] < 1800) {
    // Si la sesión existe y ha pasado menos de 1800 segundos (30 minutos)
    $nombreUsuario = $_SESSION['usuario'];
    $loginTime = $_SESSION['login_time'];
    $enlace = '<a href="index.php?c=index&f=index&p=cerrar_sesion" class="headeritem">Cerrar sesión</a>';
} else {
    // Si no hay sesión o ha pasado más de 1800 segundos
    $nombreUsuario = ""; // O cualquier otro valor predeterminado
    $loginTime = time(); // Inicializamos la variable de sesión "login_time"
    $_SESSION['login_time'] = $loginTime;
    $enlace = '<a href="index.php?c=index&f=index&p=login" class="headeritem">Iniciar sesión</a>';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->  
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/styles.css" rel="stylesheet">       
        <link rel="stylesheet" 
        href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" 
        crossorigin="anonymous">

        <title>Productos</title>
    </head> 
    <body>
    <header>
        <a href="index.html" class="empresa">
            <img class="logo" alt="logo-empresa" src="assets/imagenes/EL-sapito.webp">
            <h2 class="nombre-empresa">Muebleria El sapito</h2>
        </a>
        <nav class="nav-item">
            <ul>
                <li class="headeritem"> 
                    <?php if (!empty($_SESSION['usuario'])) : ?> 
                        <span>Hola, <?php echo $_SESSION['usuario']; ?></span> 
                        <!-- Aquí se muestra el nombre de usuario --> 
                        <?php endif; ?> </li>
                <li>
                    <a class="headeritem" href="index.php">Inicio</a>
                </li>
                <li>
                    <a href="index.php?c=index&f=index&p=contacto" class="headeritem" >Contacto</a>
                </li>
                <li>
                    <a href="index.php?c=Categorias&f=index" class="headeritem">Categorias</a>
                </li>
                <li>
                    <a href="index.php?c=Productos&f=index" class="headeritem">Productos</a>
                </li>
                <li>
                    <?php echo $enlace; ?>
                </li>
                <!-- <li class="headeritem">Mi cuenta
                    <ul class="submenu">
                        <li><a href="index.php?c=index&f=index&p=login" class="submenu-item">Iniciar sesión</a></li>
                        <li><a href="index.php?c=index&f=index&p=registrarse" class="submenu-item">Registrarse</a></li>
                    </ul>
                </li> -->
            </ul>
        </nav>
    </header>
        <?php
       
        if (!empty($_SESSION['mensaje'])) {
            
        ?>
            <div class="mt-2 alert alert-<?php echo $_SESSION['color']; ?>
             alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['mensaje']; ?>  
            </div>
            <?php
            unset($_SESSION['mensaje']);
            unset($_SESSION['color']);
        }//end if 
        ?>
    </body>
</html>