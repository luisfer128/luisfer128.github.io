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
    <style>
    .slider {
        overflow: hidden;
        margin-bottom: 15px;
    }

    .slides {
        display: flex;
        transition: all 1s;
    }

    .slide {
        flex: 0 0 100%;
        height: 100%;
    }

    #slide1:checked ~ .slides {
        transform: translateX(0);
    }

    #slide2:checked ~ .slides {
        transform: translateX(-100%);
    }

    #slide3:checked ~ .slides {
        transform: translateX(-200%);
    }

    #slide4:checked ~ .slides {
        transform: translateX(-300%);
    }

    .slide-image {
        width: 100%;
        object-fit: cover;
    }

    .slider-nav {
        text-align: center;
    }

    .slider-nav label {
        display: inline-block;
        width: 15px;
        height: 15px;
        background: #666;
        border-radius: 50%;
        cursor: pointer;
        margin: 0 5px;
    }

    #slide1:checked ~ .slider-nav label:nth-child(1),
    #slide2:checked ~ .slider-nav label:nth-child(2),
    #slide3:checked ~ .slider-nav label:nth-child(3),
    #slide4:checked ~ .slider-nav label:nth-child(4) {
        background: #333;
    }

    input[type="radio"] {
        position: absolute;
        opacity: 0;
    }
    /*Servicios*/
    .container {
        display: flex;
        justify-content: space-between;
        margin: 20px;
    }
    .column {
        flex: 1;
        text-align: center;
        padding: 5px;
        border: 1px solid #ccc;
        margin: 0 10px 0 10px;
        background-color: #379734;
    }
    .column a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
        font-size: 20px;
        display: block;
        transition: color 0.2s ease;
    }
    .column a:hover {
        color: #ffffff;
    }
    .column img {
        width: 100%;
        height: auto;
        margin-bottom: -35px;
    }
    .column-services{
        margin: 0;
    }
    /*Mision vision*/
    #content {
        flex: 1;
        padding: 20px; 
    }
    #container-mision {
        display: flex;
        margin: 20px; 
    }
    .mission-section {
        margin-bottom: 40px; 
        text-align: center;
    }
    #image {
        flex: 1;
        text-align: center;
        margin: auto; 
    }
    #mision-imagen {
        max-height: 350px; 
        width: auto;
    }  
    /*Seguidores*/

    .content-social{
        margin: 0;
        width: 100%;
        height: 60vh;
    }
    .section_media{
        width: 100%;
        height: 100%;
        position: relative;
        background-image: url(assets/imagenes/inicio/pillows.webp);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        display: flex;
        text-align: center;
        align-items: center;
        justify-content: center;
    }
    .sec_media{
        display: flex;
        flex-direction: row;
        text-transform: uppercase;
    }
    .social-box{
        text-align: center;
        margin: 0 35px;
    }
    .social-box #facebook,
    .social-box #instagram{
        color: #1a1919;
        font-size: 55px;
        margin-bottom: 5px;
        padding: 10px 20px;
    }
    .social-box #facebook {
        text-shadow: #CCC 1px 0px 40px, #757575 1px 0px 10px, rgb(3, 25, 122) 1px 0px 5px;
    }   
    .social-box #instagram {
        text-shadow: #CCC 1px 0px 40px, #757575 1px 0px 10px, rgb(122, 3, 116) 1px 0px 5px;
    }
    .sec_media span{
        font-size: 45px;
        color: #1b1b1b;        
    }
    /**/
    .container-cotizacion {
        text-align: center;
        padding: 30px;
        display: grid;
        grid-template-columns: repeat(3,1fr);
        gap: 20px;
    }

    .cotizacion-button {
        display: inline-block;
        padding: 15px 30px;
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border: none;
        border-radius: 4px;
        font-size: 25px;
        transition: background-color 0.3s ease;
    }

    .cotizacion-button:hover {
        background-color: #45a049;
    }
    @media only screen and (max-width: 800px) {
        .slider {
            margin-top: 120px;
        }

        .container {
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }

        .column {
            margin: 10px 0;
        }

        .column img {
            margin-bottom: 0;
        }

        #container-mision {
            flex-direction: column;
            align-items: center;
        }

        #content {
            padding: 10px;
        }

        #image {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        #mision-imagen {
            height: auto;
            width: 100%;
        }

        .container-cotizacion {
            grid-template-columns: 1fr;
        }

        .cotizacion-button {
            font-size: 20px;
        }

        .seguidores {
            margin: 20px 0;
        }
    }
    </style>   
    </head> 
    <body>
    <div class="slider">
        <input type="radio" name="slider" id="slide1" checked>
        <input type="radio" name="slider" id="slide2">
        <input type="radio" name="slider" id="slide3">
        <input type="radio" name="slider" id="slide4">

        <div class="slides">
            <div class="slide">
                <img class="slide-image" src="assets/imagenes/inicio/2.webp" alt="Imagen 1">
            </div>
            <div class="slide">
                <img class="slide-image" src="assets/imagenes/inicio/202307-Slider-Espacity-Living-1.webp" alt="Imagen 2">
            </div>
            <div class="slide">
                <img class="slide-image" src="assets/imagenes/inicio/maxresdefault.webp" alt="Imagen 3">
            </div>
            <div class="slide">
                <img class="slide-image" src="assets/imagenes/inicio/Slide_shopify_dizzains_3-02.webp" alt="Imagen 4">
            </div>
        </div>

        <div class="slider-nav">
            <label for="slide1"></label>
            <label for="slide2"></label>
            <label for="slide3"></label>
            <label for="slide4"></label>
        </div>
    </div>

    <div class="container">
        <div class="column">
            <a href="muebles.html">
                <img src="assets/imagenes/inicio/muebles.webp" alt="Muebles">
                <h2 class="column-services">Muebles</h2>
            </a>
        </div>
        <div class="column">
            <a href="comedores.html">
                <img src="assets/imagenes/inicio/Comedores.webp" alt="Comedores">
                <h2 class="column-services">Comedores</h2>
            </a>
        </div>
        <div class="column">
            <a href="armario.html">
                <img src="assets/imagenes/inicio/armario.webp" alt="Armarios">
                <h2 class="column-services">Armarios</h2>
            </a>
        </div>
    </div>

    <div id="container-mision">
        <div id="content">
            <div class="mission-section">
                <h1>Misión</h1>
                <p>
                    En nuestra empresa de mueblería, nos comprometemos a ofrecer productos de alta calidad
                    que mejoren la vida diaria de nuestros clientes. Nos esforzamos por superar las expectativas
                    mediante la creación y entrega de mobiliario innovador y elegante, combinando diseño creativo,
                    artesanía experta y materiales duraderos. Nuestro objetivo es proporcionar soluciones de decoración
                    integral que transformen espacios en entornos acogedores y funcionales, asegurando la satisfacción
                    total de quienes confían en nosotros para dar vida a sus ambientes soñados.
                </p>
            </div>
            <div class="mission-section">
                <h1>Visión</h1>
                <p>
                    Ser la principal fuente de inspiración para hogares y espacios comerciales, proporcionando
                    soluciones de mobiliario excepcionales que reflejen estilo, funcionalidad y calidad incomparables.
                    Aspiramos a enriquecer la vida de nuestros clientes mediante la creación de ambientes que inspiren
                    comodidad, elegancia y bienestar en cada rincón del mundo.
                </p>
            </div>
        </div>
        <div id="image">
            <img id="mision-imagen" src="assets/imagenes/inicio/mision-vision.webp" alt="Imagen de la empresa">
        </div>
    </div>

    <div class="container-cotizacion">
        <a id="cotizacion" class="cotizacion-button" href="cotizacion.html">Obtener Cotización</a>
        <a id="pedido" class="cotizacion-button" href="pedidoproducto.html">Pedido de productos</a>
        <a id="feed" class="cotizacion-button" href="feedback.html">Feedback</a>
    </div>

    <section class="content-social">
        <div class="section_media">
            <div class="sec_media">
                <div class="social-box">
                    <h4 id="facebook">Facebook</h4>
                    <span>440k</span>
                </div>
                <div class="social-box">
                    <h4 id="instagram">Instagram</h4>
                    <span>95k</span>
                </div>
            </div>
        </div>
    </section>
       
    </body>
</html>

<?php
require_once FOOTER; ?>
