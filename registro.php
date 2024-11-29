<?php
// Conexión a la base de datos
require 'conexion.php';

// Inicializar mensaje
$mensaje = "";

if (isset($_POST['registro'])) {
    // Obtener los valores del formulario
    $usuario = trim(mysqli_real_escape_string($conn, $_POST['nombre_user']));
    $contraseña = trim(mysqli_real_escape_string($conn, $_POST['contraseña_user']));
    $correo = trim(mysqli_real_escape_string($conn, $_POST['correo_user']));
    $rol = trim(mysqli_real_escape_string($conn, $_POST['rol'])); // Obtener el rol seleccionado

    // Validación de formato de correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Correo electrónico no válido.";
    } 
    // Validación de longitud de la contraseña
    elseif (strlen($contraseña) < 6) {
        $mensaje = "La contraseña debe tener al menos 6 caracteres.";
    } 
    // Verificar si el usuario ya existe
    else {
        $sql_check = "SELECT * FROM usuarios WHERE nombre_user = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $usuario);
        $stmt_check->execute();
        $resultado = $stmt_check->get_result();

        if ($resultado->num_rows > 0) {
            $mensaje = "El nombre de usuario ya está en uso. Por favor elige otro.";
        } else {
            // Encriptar la contraseña para mayor seguridad
            $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario con su rol en la base de datos
            $sql = "INSERT INTO usuarios (nombre_user, contraseña_user, correo_user, rol) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $usuario, $contraseña_hash, $correo, $rol);

            if ($stmt->execute()) {
                $mensaje = "Usuario registrado exitosamente.";
            } else {
                $mensaje = "Error al registrar el usuario: " . $conn->error;
            }

            $stmt->close();
        }
        $stmt_check->close();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Registro</title>
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
                    <!-- Mensaje de registro -->
                    <?php if (!empty($mensaje)): ?>
                        <div class="alert alert-info"><?php echo $mensaje; ?></div>
                    <?php endif; ?>

                    <!-- Formulario de registro -->
                    <form action="registro.php" method="POST">
                        <h2 class="mt-5 mb-4">Regístrate</h2>

                        <div class="form-group">
                            <input type="text" class="form-control" name="nombre_user" placeholder="Nombre de usuario" required>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="contraseña_user" placeholder="Contraseña" required>
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control" name="correo_user" placeholder="Correo" required>
                        </div>

                        <div class="form-group">
                            <label for="rol">Selecciona el tipo de usuario:</label>
                            <select class="form-control" name="rol" required>
                                <option value="user">Usuario</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" name="registro">Registrarse</button>
                    </form>

                    <p class="mt-3">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
