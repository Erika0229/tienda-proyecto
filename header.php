<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión solo si no está activa
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Las D'licias</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <nav>
            <div class="logo">
                <img src="img/logo.jpeg" alt="Logo">
            </div>
            <ul class="nav-links">
                <li><a href="catalogo.html"> INICIO</a></li>
                <li><a href="registro.php"> REGISTRO</a></li>
                <li><a href="tienda.php"> MENÚ</a></li>
                <li><a href="contactanos.html"> CONTACTO </a></li>
                <?php if (isset($_SESSION['nombre_user'])): ?>
                    <li><a href="#">Hola, <?php echo htmlspecialchars($_SESSION['nombre_user']); ?>!</a></li>
                    <li><a href="cerrar_sesion.php">Cerrar sesión</a></li>

                <?php else: ?>
                    <li><a href="login.html">Iniciar sesión</a></li>
                <?php endif; ?>
                <div class="navbar-end">
                        <div class="navbar-item">
                            <div class="buttons">
                                <a href="carrito.php" class="button is-success">
                                    <strong>Ver carrito </strong>
                                </a>
                            </div>
                        </div>
                    </div>


            </ul>
        </nav>
    </header>
</body>
</html>
