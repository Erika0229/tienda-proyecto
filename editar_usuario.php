<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    require 'conexion.php'; // Conexión a la base de datos

    // Verificar si se pasó un ID de usuario
    if (isset($_GET['id'])) {
        $id_user = $_GET['id'];

        // Consultar la información del usuario
        $sql = "SELECT id_user, nombre_user, correo_user, rol FROM usuarios WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
        } else {
            echo "Usuario no encontrado.";
            exit;
        }
    } else {
        echo "ID de usuario no especificado.";
        exit;
    }

    $conn->close();
} else {
    header('Location: tienda.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Editar Usuario</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Fondo claro */
        }

        /* Estilos para la barra de navegación */
        .navbar {
            background-color: #003366; /* Azul oscuro */
        }
        .navbar a {
            color: white !important;
            font-size: 18px;
            padding: 15px 20px;
        }
        .navbar a:hover {
            background-color: #00509e; /* Azul más brillante al pasar el mouse */
        }

        .container {
            margin-top: 50px;
            border: 1px solid #ced4da;
            border-radius: 10px;
            background-color: #ffffff; /* Fondo blanco para el formulario */
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 30px;
            color: #003366; /* Título en azul oscuro */
        }

        label {
            font-weight: bold;
            color: #333; /* Color de las etiquetas */
        }

        input[type="text"],
        input[type="email"],
        select {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            margin-bottom: 20px;
        }

        button[type="submit"] {
            background-color: #28a745; /* Verde para el botón de actualizar */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #218838; /* Verde más oscuro al pasar el mouse */
        }

        .btn-secondary {
            margin-left: 10px; /* Espaciado entre botones */
        }

        /* Estilos para el pie de página */
        footer {
            background-color: #003366; /* Azul oscuro */
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#"> </a> <!-- Barra vacía para diseño -->
</nav>

<div class="container">
    <h2>Editar Usuario</h2>
    <form action="actualizar_usuario.php" method="POST">
        <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($usuario['id_user']); ?>">
        <div class="form-group">
            <label for="nombre_user">Nombre:</label>
            <input type="text" class="form-control" id="nombre_user" name="nombre_user" value="<?php echo htmlspecialchars($usuario['nombre_user']); ?>" required>
        </div>
        <div class="form-group">
            <label for="correo_user">Correo:</label>
            <input type="email" class="form-control" id="correo_user" name="correo_user" value="<?php echo htmlspecialchars($usuario['correo_user']); ?>" required>
        </div>
        <div class="form-group">
            <label for="rol">Rol:</label>
            <select class="form-control" id="rol" name="rol" required>
                <option value="user" <?php echo $usuario['rol'] === 'user' ? 'selected' : ''; ?>>Usuario</option>
                <option value="admin" <?php echo $usuario['rol'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="gestion_usuarios.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<!-- Pie de página -->
<footer>
    <p>&copy; 2024 Mi Tienda | Todos los derechos reservados.</p>
</footer>

</body>
</html>
