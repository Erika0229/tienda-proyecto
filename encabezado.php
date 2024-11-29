<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión solo si no está activa
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras con PHP y MySQL - By Parzibyte</title>
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
</head>

<body>

       
      
    
          
                <div class="navbar-item">
                <div class="contenedor">
        

  
</div>



                </div>
            </div>
        </div>
    </nav>
    </div>
</div>
</header>
<main class="contenido">
    <div class="titulo">
        <h2 style="font-size: 2em;">¡Carrito De Compras!</h2> <!-- Aumenta el tamaño de la letra -->
    </div>
</main>

                                            </body>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", () => {
            const boton = document.querySelector(".navbar-burger");
            const menu = document.querySelector(".navbar-menu");
            boton.onclick = () => {
                menu.classList.toggle("is-active");
                boton.classList.toggle("is-active");
            };
        });
    </script>
    <section class="section">