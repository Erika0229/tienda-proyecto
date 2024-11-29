<?php
require 'conexion.php';

session_start(); // Iniciar sesión

// Inicializar mensaje
$mensaje = "";

if (isset($_POST['login'])) {
    $usuario = trim(mysqli_real_escape_string($conn, $_POST['nombre_user']));
    $contraseña = trim($_POST['contraseña_user']); // Limpiar entrada

    $sql = "SELECT * FROM usuarios WHERE nombre_user = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 0) {
        $mensaje = "El usuario no existe.";
    } else {
        $fila = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($contraseña, $fila['contraseña_user'])) {
            // Iniciar sesión del usuario
            $_SESSION['usuario_id'] = $fila['id'];  // Asume que tienes un campo 'id' en la tabla de usuarios
            $_SESSION['nombre_user'] = $fila['nombre_user']; // Almacenar nombre de usuario
            $_SESSION['rol'] = $fila['rol'];  // Guardar el rol del usuario

            // Redirigir según el rol
            if ($fila['rol'] === 'admin') {
                header('Location: panel_administrador.php');
                exit();
            } else {
                header('Location: tienda.php');
                exit();
            }
        } else {
            $mensaje = "La contraseña es incorrecta.";
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página de inicio de sesión</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="contenedor">
    <header class="header">
        <nav>
            <div class="logo">
                <img src="img/logo.jpeg" alt="Logo">
            </div>
            <ul class="nav-links">
                <li><a href="catalogo.html">INICIO</a></li>
                <li><a href="registro.php">REGISTRO</a></li>
                <li><a href="tienda.php">MENÚ</a></li>
                <li><a href="contactanos.html">CONTACTO</a></li>
            </ul>
        </nav>
    </header>
    
    <aside class="sidebar">
        <div class="logo_sidebar">
            <img src="img/logo_sb.jpeg" alt="">
        </div>
    </aside>

    <main class="contenido">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- Mensaje de inicio de sesión -->
                    <?php if (!empty($mensaje)): ?>
                        <div class="alert alert-danger"><?php echo $mensaje; ?></div>
                    <?php endif; ?>

                    <!-- Formulario de inicio de sesión -->
                    <form action="login.php" method="POST">
                        <h2 class="mt-5 mb-4">Iniciar sesión</h2>

                        <div class="form-group">
                            <input type="text" class="form-control" name="nombre_user" placeholder="Nombre de usuario" required>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="contraseña_user" placeholder="Contraseña" required>
                        </div>

                        <div class="form-group">
                            <label for="rol">Selecciona tu rol:</label>
                            <select class="form-control" name="rol" required>
                                <option value="user">Usuario</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" name="login">Iniciar sesión</button>
                    </form>

                    <p class="mt-3">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
                </div>
            </div>
        </div>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </main>
</div>
</body>
<footer>
    <p>© <?php echo date("Y"); ?> Las D'licias. Todos los derechos reservados.</p>
</footer>

<style>
    footer {
        background-color: #003366; /* Azul oscuro */
        color: white; /* Texto blanco */
        padding: 1rem 0; /* Espaciado */
        text-align: center; /* Centrar texto */
        position: relative; /* Posición relativa */
        bottom: 0; /* Asegurarse de que el pie esté al final */
        width: 100%; /* Ancho completo */
    }
</style>

</html>


