<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="">
        <title>Registro</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <style>
            .register-container{
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
            .register-title{
                font-family:'Montserrat','Arial',sans-serif;
                color: #FFF;
                text-align: center;
                font-size: 1.5rem;
                margin-bottom: 32px;
            }
            .register-form-background{
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
            .register-form{
                text-transform: capitalize;
                font-family: 'Lato','Arial',sans-serif;
                text-align: center;
            }
            .register-form input{
                width: 90%;
                margin-bottom: 3px;
                border-radius: 30px;
                border: 1px solid #DAE2F1;
                padding: 15px 20px;
                color:  #555555;
                font-size: .9rem;
                transition: .4s;
            }
            .register-form input:focus {
                border-color: #F5D7E3;
                outline: none;
            }
            .register-form [type="submit"]{
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
            .register-form [type="submit"]:hover{
                cursor: pointer;
                background: rgba(105,9,25,0.7483368347338936);
            }
            .inicio_sesion {
                margin-top: 20px;
                text-align: center;
                font-size: 0.9rem;
                color: #fff;
            }
            .inicio_sesion h4 {
                margin-bottom: 10px;
            }
            .inicio_sesion a {
                color:  #E89ACF;
                text-decoration: none;
                transition: color 0.3s;
            }
            .inicio_sesion a:hover {
                color: #F5D7E3;
            }
            .error-message {
                display:block;
                color: #e74c3c;
                font-size: 1rem;
                margin-top: 5px;
                text-align: center;
                font-weight: bold;
            }
            .feedback-message{
                background-color: #D9CCE3; 
                color: #333333; 
                padding: 10px; 
                text-align: center;
                text-transform: none;
            }
        </style>
    </head>
    <body>
        <?php 
        $titulo = "Registrarse";
        require_once 'config/Conexion.php';
        $con = Conexion::getConexion();
        function clear_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $errorEmail = $errorPassword = $errorUsername = "";
        $username = $password = $email = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validar nombre de usuario
            if (empty($_POST['username'])) {
                $errorUsername = "El Nombre de usuario es requerido.";
            } else {
                $username = clear_input($_POST['username']);
            }

            // Validar correo electrónico
            if (empty($_POST['email'])) {
                $errorEmail = "El correo electrónico es requerido.";
            } else {
                $email = clear_input($_POST['email']);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errorEmail = "Formato de correo electrónico inválido.";
                }
            }

            // Validar contraseña
            if (empty($_POST['password'])) {
                $errorPassword = "La contraseña es requerida.";
            } else {
                $password = clear_input($_POST['password']);
            }

            // Procesar el formulario si no hay errores
            if (empty($errorUsername) && empty($errorEmail) && empty($errorPassword)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Verificar si el correo o el nombre de usuario ya existen
                $sql_check = "SELECT * FROM usuario WHERE email = :email OR usuario = :username";
                $stmt_check = $con->prepare($sql_check);
                $stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt_check->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt_check->execute();
                $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $mensaje = "El correo electrónico o el nombre de usuario ya están en uso.";
                } else {
                    // Insertar el nuevo usuario si no hay coincidencias
                    $sql_insert = "INSERT INTO usuario (email, password, usuario) VALUES (:email, :hashedPassword, :username)";
                    $stmt_insert = $con->prepare($sql_insert);

                    if ($stmt_insert) {
                        $stmt_insert->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt_insert->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
                        $stmt_insert->bindParam(':username', $username, PDO::PARAM_STR);
                        
                        if ($stmt_insert->execute()) {
                            $mensaje = "Registro completado, Bienvenido {$username} !";
                        } else {
                            $mensaje = "Error al ingresar el usuario";
                        }
                    } else {
                        $mensaje = "Error.";
                    }
                }
            }
        }
        ?>
        <section>
            <div class="register-container">
                <?php if (isset($mensaje)): ?>
                    <div class="feedback-message">
                        <?php echo $mensaje; ?>
                    </div>
                <?php endif; ?>
                <div class="register-form-background">
                    <h1 class="register-title">Registrarse</h1>
                    <form class="register-form" action="" method="post">
                        <div class="form-group">
                            <input type="text" id="username" name="username" placeholder="Nombre de usuario" autocomplete="off">
                            <span class="error-message"><?php echo $errorUsername; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Correo" autocomplete="off">
                            <span class="error-message"><?php echo $errorEmail; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" name="password" placeholder="Contraseña" autocomplete="off">
                            <span class="error-message"><?php echo $errorPassword; ?></span>
                        </div>
                        <input type="submit" value="Registrarse" class="submit-button">
                        <div class="inicio_sesion">
                            <h4>¿Ya tienes cuenta?</h4>
                            <a href="index.php?c=index&f=index&p=login">Iniciar Sesión</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </body>
</html>