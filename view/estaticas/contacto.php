<?php require_once HEADER; ?>
        
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->  
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">       
    <!-- FONT AWESOME -->
    <link rel="stylesheet" 
    href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
    integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" 
    crossorigin="anonymous">

    <title>Inicio|EL SAPITO</title>
    </head> 
    <style>
        body{
            margin: 0;
            padding: 0;  
            box-sizing: border-box;          
            background: linear-gradient(90deg, rgba(0,36,3,0.2) 0%, rgba(9,121,71,0.5) 50%, rgba(0,36,0,0.4) 100%);
        }
        .container_contact {
            display: flex;
            justify-content: space-around;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.22);
            padding: 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        #content_contact {
            max-width: 500px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.62);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 1);
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .content_title {
            margin-bottom: 10px;
        }
        .info-contact {
            margin: 20px 0;
            text-align: left;
        }
        .container_form {
            max-width: 400px;
            width: 80%;
            text-align: left;
            background: rgba(255, 255, 255, 0.62);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 1);
            border-radius: 16px;
            padding: 20px;
            padding-top:20px ;
            margin-left: 10%;
        }
        form {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            width: 100%;
        }
        
        label {
            margin-top: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 2px;
        }
        input[type="checkbox"]:checked {
            color:rgb(31, 221, 14);
        }
        input[type="submit"] {
            margin-top: 5px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .container_contact {
                flex-direction: column;
                align-items: center;
            }
            .container_form{
                flex-direction: column;
                align-items: center;
                max-width: 100%;
            }
            
        }
    </style>
    <body>
    <main class="container_contact">
        <section id="content_contact">
            <div class="content_title">
                <h1 style="font-size: 42px;margin-bottom: 10px;padding: 16px;">Contacto</h1>
                <p  style="font-size: 16px; margin: 5px 0;">Estamos encantados de estar en contacto contigo. Utiliza la siguiente información para comunicarte con nosotros o déjanos un mensaje a través del formulario de contacto.</p>
            </div>

            <div class="info-contact">
                <h2>Información de Contacto</h2>
                <p><strong>Dirección:</strong> Calle falsa 123</p>
                <p><strong>Teléfono:</strong> +593 999999999</p>
                <p><strong>Correo Electrónico:</strong> info@muebleriasapito.com</p>
            </div>
        </section>

        <section class="container_form flex-container">
            <h2>Formulario de Contacto</h2>
            <form id="contacto-form" action="contacto.html" method="post">
                <div class="grupo-form">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" >
                    <span class="error-formulario"></span>
                </div>
                <div class="grupo-form">
                    <label for="cedula">Cedula:</label>
                    <input type="text" id="cedula" name="cedula" >
                    <span class="error-formulario"></span>
                </div>
                <div class="grupo-form">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" >
                    <span class="error-formulario"></span>
                </div>
                <div class="grupo-form">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono">
                    <span class="error-formulario"></span>
                </div>
                <div class="grupo-form">
                    <label for="motivo">Motivo de Contacto:</label>
                    <select id="motivo" name="motivo">
                        <option value="consulta">Consulta</option>
                        <option value="comentario">Comentario</option>
                        <option value="queja">Queja</option>
                        <option value="otro">Otro</option>
                    </select>
                    <span class="error-formulario"></span>
                </div>
                <div class="grupo-form">
                    <label for="miCheckbox">¿Desea suscribirse al boletin semanal?</label><br>
                    <label for="miCheckbox">Suscribirse:</label>
                    <input type="checkbox" id="miCheckbox" name="miCheckbox">
                </div>
                <input type="submit" value="Enviar Mensaje">
            </form>
        </section>
    </main>
    <script>
            document.addEventListener("DOMContentLoaded", function() {
            
            var formulario = document.getElementById("contacto-form");

            formulario.addEventListener("submit", function(event) {
            
                if (validarFormulario()) {
                    alert('Correo enviado correctamente');
                } else {
                    
                    event.preventDefault();
                    alert('Ingrese todos los datos requeridos correctamente');
                }
            });
            
            function validarCedula() {
                var cedula = document.getElementById("cedula").value.trim();
                
                var regexCedula = /^\d{10}$/;
                if (!regexCedula.test(cedula)) {
                    alert("Ingrese una cédula válida con 10 dígitos numéricos.");
                    return false;
                }
                return true;
            }
            
            function validarTelefono() {
                var telefono = document.getElementById("telefono").value.trim();
                
                var regexTelefono = /^(?:\+593|0)(?:(?!00)\d{2})\d{8}$/;
                if (!regexTelefono.test(telefono)) {
                    mostrarError("error-telefono", "Ingrese un número de teléfono válido.");
                    return false;
                }
                return true;
            }
            function validarCorreo() {
                var correo = document.getElementById("email").value.trim();
                
                var regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!regexCorreo.test(correo)) {
                    alert("Ingrese una dirección de correo electrónico válida.");
                    return false;
                }
                return true;
            }
            function validarMotivo() {
                var motivo = document.getElementById("motivo").value;
                if (motivo === "") {
                    mostrarError("error-motivo", "Por favor, seleccione un motivo de contacto.");
                    return false;
                }
                return true;
            }
            
            function mostrarError(idCampo, mensaje) {
                
                var campo = document.getElementById(idCampo);
                var elementoError = campo.nextElementSibling; 
                elementoError.innerHTML = mensaje;
                elementoError.style.display = "block";
                elementoError.style.color = "red";
                setTimeout(function() {
                    elementoError.style.display = "none";
                }, 4000);
            }
            
            function validarFormulario() {
                
                var campos = document.querySelectorAll("#contacto-form input, #contacto-form select");
                
                for (var i = 0; i < campos.length; i++) {
                    if (campos[i].value.trim() === "") {
                        mostrarError(campos[i].id, "Complete este campo antes de enviar el formulario.");
                        return false;
                    }
                }
                
                return true;
            }
        });
    </script>
    </body>
</html>

<?php require_once FOOTER; ?>