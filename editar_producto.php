<?php
include('conexion.php');
include('funciones.php');

// Verificar si se ha enviado el ID del producto
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del producto
    $stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit();
    }
    $stmt->close();
} else {
    echo "ID de producto no proporcionado.";
    exit();
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Preparar la consulta de actualización
    if (!empty($_FILES['imagen']['name'])) {
        // Si se ha subido una nueva imagen, actualizar la imagen también
        $imagen = $_FILES['imagen']['name'];
        $ruta_imagen = "uploads/" . basename($imagen);

        if (uploads($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
            // Actualizar también la imagen en la base de datos
            $stmt = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ? WHERE id = ?");
            $stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $ruta_imagen, $id);
        } else {
            echo "Error al subir la imagen.";
            exit();
        }
    } else {
        // Si no se sube una nueva imagen, solo actualizamos los otros datos
        $stmt = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $id);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Producto actualizado con éxito.";
        header("Location: gestion_productos.php"); // Redirige a la página de gestión de productos
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #fff; /* Fondo blanco */
            font-family: 'Arial', sans-serif;
        }

        /* Barra de navegación con color azul oscuro */
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

        /* Estilo para el contenedor del formulario */
        .container {
            margin-top: 50px;
            background-color: #ffffff; /* Fondo blanco para el formulario */
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
            border: 1px solid #00509e; /* Azul más claro para los bordes */
        }

        h2 {
            text-align: center;
            color: #003366; /* Azul oscuro para el título */
            font-size: 32px;
            margin-bottom: 25px;
            font-weight: bold;
        }

        label {
            font-weight: bold;
            color: #003366; /* Azul oscuro para las etiquetas */
        }

        input[type="text"],
        input[type="number"],
        textarea {
            border: 2px solid #00509e; /* Azul más claro para bordes */
            border-radius: 10px;
            padding: 15px;
            width: 100%;
            margin-bottom: 25px;
            font-size: 16px;
            background-color: #fff; /* Fondo blanco para los campos */
            color: #000; /* Texto negro */
        }

        textarea {
            height: 120px; /* Mayor altura para el textarea */
        }

        input[type="file"] {
            margin-bottom: 25px;
        }

        input[type="submit"] {
            background-color: #00509e; /* Azul claro para el botón */
            color: white;
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #003366; /* Azul oscuro al pasar el mouse */
        }

        .current-image {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        .form-footer {
            text-align: center;
            margin-top: 30px;
        }

        .form-footer a {
            color: #00509e;
            font-size: 16px;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

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
    <!-- Barra de navegación con color azul oscuro -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#"> </a> <!-- Barra vacía -->
    </nav>

    <!-- Formulario de edición de producto -->
    <div class="container">
        <h2>Editar Producto</h2>

        <form action="editar_producto.php?id=<?php echo $producto['id']; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

            <label>Nombre del Producto</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>

            <label>Descripción</label>
            <textarea name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>

            <label>Precio</label>
            <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>

            <label>Imagen actual</label>
            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="current-image"><br>

            <label>Cambiar Imagen</label>
            <input type="file" name="imagen">

            <input type="submit" name="submit" value="Actualizar Producto">
        </form>

        <div class="form-footer">
            <a href="gestion_productos.php">Volver a la Gestión de Productos</a>
        </div>
    </div>

    <!-- Pie de página -->
    <footer>
        <p>&copy; 2024 Mi Tienda | Todos los derechos reservados.</p>
    </footer>

</body>

</html>
