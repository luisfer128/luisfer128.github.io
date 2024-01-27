<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="">
</head>
<body>
<?php
// Eliminar cookies
if (isset($_COOKIE['usuario_id']) && isset($_COOKIE['rol'])) {
    // Establece el tiempo de expiración en el pasado para eliminar la cookie
    setcookie("usuario_id", "", time() - 3600, "/");
    setcookie("rol", "", time() - 3600, "/");
}

// Destruir la sesión actual
session_start();
session_destroy();

// Redirigir al usuario a la página de inicio
header("Location: ./index.php");
exit;
?>
</body>
</html>


