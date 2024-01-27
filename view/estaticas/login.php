//autor: Revelo Quintana Jose David y Cedeño Paredes Romina
<?php
require_once 'config/Conexion.php';

$errorPassword = $errorEmail = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $con = Conexion::getConexion();

    try {
        // Preparar y ejecutar la consulta SQL
        $sql = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verificar la contraseña con el hash almacenado
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['rol'] = $user['roles'];

                // Redirigir según el rol
                switch ($user['roles']) {
                    case 'admin-global':
                    case 'gerente':
                        header('Location: index.php?c=categorias&f=index');
                        exit;
                    case 'vendedor':
                    case 'usuario':
                        header('Location: index.php?c=Productos&f=index');
                        exit;
                    default:
                        header("Location: index.php");
                        exit;
                }
            } else {
                $errorPassword = "<div class='error-message'>Contraseña incorrecta.</div>";
            }
        } else {
            $errorEmail = "<div class='error-message'>Correo no registrado.</div>";
        }

        session_start();

        // Verificar si el usuario está autenticado
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
            // Crear cookies para guardar la sesión del usuario
            setcookie("usuario_id", $_SESSION['usuario_id'], time() + 3600, "/");
            setcookie("rol", $_SESSION['rol'], time() + 3600, "/");
            // Redirigir al usuario a la página de inicio
            header("Location: index.php");
            exit;
        } else {
            // Redirigir al usuario a la página de inicio de sesión si no está autenticado
            header("Location: login.php");
            exit;
        }
    } catch (PDOException $e) {
        die("Error en la consulta: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Revelo Quintana Jose David y Cedeño Paredes Romina">
        <title>DX-Iniciar Sesion</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <style>
        .login-container {
            height: 90vh;
            text-transform: uppercase;
            position: relative;
            background: rgb(80,21,21);
            background: radial-gradient(circle, rgba(80,21,21,0.7847514005602241) 0%, rgba(27,9,25,0.7483368347338936) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .login-title{
            font-family:'Montserrat','Arial',sans-serif;
            color: #FFF;
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 32px;
        }
        .login-form-background {
            width: 460px;
            padding: 32px;
            align-self: center;
            background: rgba(80,21,21,0.7847514005602241);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(4.9px);
            -webkit-backdrop-filter: blur(4.9px);
            border: 1px solid rgba(138, 75, 175, 0.11);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .login-form{
            text-transform: capitalize;
            font-family: 'Lato','Arial',sans-serif;
            text-align: center;
        }
        .login-form input {
        
            width: 90%;
            margin-bottom: 3px;
            border-radius: 30px;
            border: 1px solid #DAE2F1;
            padding: 15px 20px;
            color: #555555;
            font-size: .9rem;
            transition: .4s;
        }
        .login-form input:focus {
            border-color: #F5D7E3;
            outline: none;
        }
        .login-form [type="submit"] {
            
            background: rgba(27,9,25,0.7483368347338936);
            border-radius: 30px;
            padding: 16px 30px;
            width: 65%;
            color: #fff;
            text-transform: uppercase;
            font-size: .8rem;
            transition: .4s;
            border: none;
            box-shadow: none;
            margin: 0;
        }

        .login-form [type="submit"]:hover {
            cursor: pointer;
            background: rgba(105,9,25,0.7483368347338936);
        }

        .error-message {
            color: #e74c3c;
            font-size: 1rem;
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .registrar_cuenta {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9rem;
            color: #fff;
        }
        .registrar_cuenta h4 {
             margin-bottom: 10px;
        }
        .registrar_cuenta a, a {
            color:  #E89ACF;
            text-decoration: none;
            transition: color 0.3s;
        }
        .registrar_cuenta a:hover {
            color: #F5D7E3;
        }
        </style>
    </head>
    <body>
        <section class="home">
            <div class="login-container">
                <div class="login-form-background">
                <h1 class="login-title">Iniciar sesión</h1>
                <form class="login-form" action="" method="post">
                    <!-- Correo electrónico -->
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="Correo">
                        <span><?php echo $errorEmail;?></span>
                    </div>
                    <!-- Contraseña -->
                    <div class="form-group">
                        <input type="password" id="password" name="password" placeholder="Contraseña">
                        <span><?php echo $errorPassword;?></span>
                    </div>
                    <input type="submit" value="Iniciar Sesion">
                    <!-- Registarse -->
                    <div class="registrar_cuenta">
                        <h4>¿No tienes cuenta?</h4>
                        <a href="index.php?c=index&f=index&p=registrarse">Registrarse</a>
                    </div>
                </form>
            </div>
        </section>
    </body>
</html>