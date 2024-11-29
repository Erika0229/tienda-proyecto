<?php include('conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Estilos globales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .contenedor {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        header {
            width: 100%;
            background-color: #003366;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header nav .logo img {
            width: 100px;
            height: auto;
        }

        .nav-links {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        .nav-links li {
            display: inline-block;
            margin-right: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1em;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #ff6347;
        }

        /* Estilos del contenido principal */
        .titulo {
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            color: #003366;
            font-size: 2em;
            font-weight: bold;
        }

        /* Estilos del formulario */
        form {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border 0.3s;
        }

        form input:focus,
        form textarea:focus {
            border-color: #ff6347;
            outline: none;
        }

        form input[type="submit"] {
            background-color: #003366;
            color: white;
            cursor: pointer;
            border: none;
            font-size: 1.2em;
            transition: background-color 0.3s, transform 0.3s;
            padding: 15px 0;
            text-align: center;
            border-radius: 5px;
        }

        form input[type="submit"]:hover {
            background-color: #ff6347;
            transform: translateY(-3px);
        }

        /* Estilos para los productos */
        .productos-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .producto {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
        }

        .producto img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .producto h3 {
            color: #003366;
            font-size: 1.6em;
            margin-bottom: 10px;
        }

        .producto p {
            font-size: 1.1em;
            color: #333;
            margin-bottom: 15px;
        }

        .producto .precio {
            font-size: 1.3em;
            color: #ff6347;
            margin-bottom: 20px;
        }

        .producto:hover {
            transform: translateY(-5px);
        }

        /* Botón volver */
        .volver-btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 1.2em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .volver-btn:hover {
            background-color: #45a049;
            transform: translateY(-3px);
        }

        /* Estilos del footer */
        footer {
            width: 100%;
            background-color: #003366;
            color: white;
            padding: 15px;
            text-align: center;
            position: fixed;
            bottom: 0;
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <header>
            <nav>
                <div class="logo">
                    <img src="img/logo.jpeg" alt="Logo">
                </div>
                <ul class="nav-links">
                    <li><a href="catalogo.html">INICIO</a></li>
                    <li><a href="panel_administrador.php">PANEL ADMIN</a></li>
                    <li><a href="tienda.php">MENÚ</a></li>
                    <li><a href="contactanos.html">CONTACTO</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <div class="titulo">
                <h2>¡Productos Subidos!</h2>
            </div>

            <!-- Formulario para subir productos -->
            <form action="subir_productos.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="nombre" placeholder="Nombre del producto" required>
                <textarea name="descripcion" placeholder="Descripción" required></textarea>
                <input type="file" name="imagen" required>
                <input type="number" step="0.01" name="precio" placeholder="Precio" required>
                <input type="submit" name="submit" value="Subir producto">
            </form>

            <!-- Mostrar productos -->
            <div class="productos-container">
                <?php
                    // Mostrar productos
                    $sql = "SELECT * FROM productos";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='producto'>";
                            echo "<img src='" . $row['imagen'] . "' alt='" . $row['nombre'] . "'>";
                            echo "<h3>" . $row['nombre'] . "</h3>";
                            echo "<p>" . $row['descripcion'] . "</p>";
                            echo "<p class='precio'>$" . $row['precio'] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No hay productos disponibles.</p>";
                    }
                ?>
            </div>

            <!-- Botón Volver -->
            <a href="panel_administrador.html">
                <button class="volver-btn">Volver</button>
            </a>
        </main>

        <!-- Footer -->
        <footer>
            <p>© <?php echo date("Y"); ?> Las D'licias. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>
</html>

<?php
function uploads($tempPath, $uploadPath) {
    return move_uploaded_file($tempPath, $uploadPath);
}

if (isset($_POST['submit'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    
    // Verificación de imagen
    if ($_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen']['name'];
        $ruta_imagen = "uploads/" . basename($imagen);

        if (uploads($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
            $sql = "INSERT INTO productos (nombre, descripcion, imagen, precio) VALUES ('$nombre', '$descripcion', '$ruta_imagen', '$precio')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<p>Producto subido correctamente.</p>";
            } else {
                echo "<p>Error al subir el producto: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Hubo un problema al cargar la imagen.</p>";
        }
    } else {
        echo "<p>Error al subir la imagen.</p>";
    }
}
?>
