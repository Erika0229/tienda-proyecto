<?php
include_once "funciones.php"; // Incluye el archivo con las funciones necesarias


// Inicia la sesión si no está iniciada
iniciarSesionSiNoEstaIniciada();

// Manejo de acciones de formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['guardar'])) {
        // Guardar producto
        $nombre = $_POST['nombre'] ?? ''; // Asegura que la variable tenga un valor por defecto
        $precio = $_POST['precio'] ?? 0; // Asegura que el precio no sea nulo
        $descripcion = $_POST['descripcion'] ?? ''; // Asegura que la descripción tenga un valor por defecto

        $imagen = $_FILES['imagen']['name'] ?? null; // Verifica si la imagen existe
        $ruta_imagen = $imagen ? "uploads/" . basename($imagen) : ''; // Solo crea la ruta si hay imagen
    
        if ($imagen && uploads($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
            $sql = "INSERT INTO productos (nombre, descripcion, imagen, precio) VALUES ('$nombre', '$descripcion', '$ruta_imagen', '$precio')";
            
            if ($conn->query($sql) === TRUE) {
                echo "Producto subido con éxito";
            } else {
                echo "Error: " . $conn->error;
            }
        } elseif ($imagen) {
            echo "Error al subir la imagen.";
        }

        if (guardarProducto($nombre, $precio, $descripcion)) {
            $mensaje = "Producto guardado exitosamente.";
        } else {
            $mensaje = "Error al guardar el producto.";
        }
    } elseif (isset($_POST['eliminar'])) {
        // Eliminar producto
        $idProducto = $_POST['id_producto'] ?? null; // Asegura que el ID no sea nulo

        if ($idProducto !== null && eliminarProducto($idProducto)) {
            $mensaje = "Producto eliminado exitosamente.";
        } else {
            $mensaje = "Error al eliminar el producto.";
        }
    }
}

// Obtener la lista de productos
$productos = obtenerProductos();

// Incluye el archivo HTML y pasa las variables necesarias
include 'gestion_productos.html';
?>
