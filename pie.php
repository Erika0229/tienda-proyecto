<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras con PHP y MySQL - By Parzibyte</title>
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <style>
        footer {
            background-color: #f5f5f5;
            padding: 1.5rem 1rem;
            text-align: center;
        }

        .footer-content {
            margin: 0;
            font-size: 1rem;
            color: #4a4a4a;
        }

        .footer-icon {
            margin: 0 5px;
            color: #3273dc; /* Color de los iconos */
        }
    </style>
</head>

<body>
    <!-- Contenido de la página -->

    <footer>
        <div class="footer-content">
            <p>© <?php echo date("Y"); ?> Tu Empresa. Todos los derechos reservados.</p>
            <p>
                <a href="#" class="footer-icon"><i class="fa fa-facebook"></i></a>
                <a href="#" class="footer-icon"><i class="fa fa-twitter"></i></a>
                <a href="#" class="footer-icon"><i class="fa fa-instagram"></i></a>
                <a href="#" class="footer-icon"><i class="fa fa-linkedin"></i></a>
            </p>
        </div>
    </footer>
</body>

</html>
