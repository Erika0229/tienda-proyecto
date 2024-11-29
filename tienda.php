<?php
session_start(); // Inicia la sesión
include 'header.php'; // Incluye el encabezado
include('conexion.php');

// Procesar eliminación de producto del carrito
if (isset($_POST['delete'])) {
    $carrito_id = $_POST['carrito_id'];
    $delete_sql = "DELETE FROM carrito WHERE id = '$carrito_id'";

    if ($conn->query($delete_sql) === TRUE) {
        header("Location: carrito.php");
        exit();
    } else {
        echo "Error al eliminar el producto del carrito: " . $conn->error;
    }
}

// Procesar adición de producto al carrito
$message = ""; // Variable para el mensaje de confirmación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];

    // Obtener el precio del producto
    $sql = "SELECT precio FROM productos WHERE id = $producto_id";
    $result = $conn->query($sql);
    
    if ($result && $producto = $result->fetch_assoc()) {
        $total = $producto['precio'];

        // Insertar el producto en el carrito con el total correspondiente
        $sql = "INSERT INTO carrito (producto_id, total) VALUES ($producto_id, $total)";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Producto agregado al carrito."; // Mensaje de éxito
        } else {
            $message = "Error: " . $conn->error; // Mensaje de error
        }
    } else {
        $message = "Producto no encontrado."; // Mensaje si no se encuentra el producto
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.1/css/bulma.min.css">
    <style>
        .productos-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
            padding: 20px;
        }
        .producto {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            background-color: #f9f9f9;
            transition: box-shadow 0.3s;
        }
        .producto:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .producto img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .nombre, .precio, .cantidad {
            font-weight: bold; /* Hacer el texto grueso */
            text-transform: uppercase; /* Convertir a mayúsculas */
            margin: 5px 0; /* Espaciado entre líneas */
        }
        footer {
            background-color: #003366;
            color: white;
            padding: 1rem 0;
            text-align: center;
            width: 100%;
        }
        .mensaje {
            color: green;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        
        /* Estilo de los títulos de las categorías */
        .categoria {
            font-size: 2.2em;
            font-weight: bold;
            margin-top: 40px;
            margin-bottom: 10px;
            text-transform: uppercase;
            color: #003366;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            transition: color 0.3s ease, transform 0.3s ease;
        }
        .categoria:hover {
            color: #ff6347; /* Rojo tomate */
            transform: scale(1.1); /* Efecto de agrandar */
        }

    </style>
</head>
<body>
    <div class="titulo">
        <h2 style="font-size: 2.5em; font-weight: bold;">¡Nuestros Deliciosos Productos!</h2>
    </div>

    <?php if ($message): ?>
        <div class="mensaje"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php
    // Categorías de productos basadas en palabras clave en el nombre o descripción
    $categorias = [
        'Hamburguesas' => ['hamburguesa', 'Korean Fried Chicken Burger'],  // Se añadió "Korean Fried Chicken Burger"
        'Pizzas' => ['pizza'],
        'Perro Caliente' => ['perro caliente', 'hot dog', 'perra', 'perro'],  // Se añadió "perro"
        'Mazorcadas' => ['mazorcada'],  // Mantenemos "mazorcada" solo en esta categoría
        'Salchipapas' => ['salchipapa', 'papas'],  // Se añadió "papas" pero sin mazorcada
        'Empanadas' => ['empanada'],
        'Bebidas' => ['coca-cola', 'sprite', 'manzana', 'colombiana', 'gaseosa', 'agua', 'bebida', 'quatro', 'coca'] // Añadidos Coca-Cola y Quatro
    ];

    // Obtener los productos de la base de datos
    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Mostrar las categorías
        foreach ($categorias as $categoria => $palabras_clave) {
            echo "<div class='categoria'>$categoria</div>";
            echo "<div class='productos-container'>";
            $result->data_seek(0);  // Reseteamos el puntero para recorrer todos los productos nuevamente
            while ($row = $result->fetch_assoc()) {
                foreach ($palabras_clave as $palabra_clave) {
                    // Excluir productos de mazorcada en salchipapas
                    if ($categoria === 'Salchipapas' && stripos($row['nombre'], 'mazorcada') !== false) {
                        continue; // No mostrar mazorcada en salchipapas
                    }
                    if (stripos($row['nombre'], $palabra_clave) !== false || stripos($row['descripcion'], $palabra_clave) !== false) {
                        // Mostrar el producto si pertenece a la categoría
                        echo "<div class='producto'>";
                        echo "<img src='" . htmlspecialchars($row['imagen']) . "' alt='" . htmlspecialchars($row['nombre']) . "'>";
                        echo "<h2 class='nombre'>" . htmlspecialchars($row['nombre']) . "</h2>";
                        echo "<p>" . htmlspecialchars($row['descripcion']) . "</p>";
                        echo "<p class='precio'>Precio: $" . htmlspecialchars($row['precio']) . "</p>";
                        echo "<form action='' method='POST'>";                
                        echo "<input type='hidden' name='producto_id' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "<input type='submit' value='Agregar al carrito' class='button is-primary' style='margin-top: 10px;'>";
                        echo "</form>";
                        echo "</div>";
                        break; // Si el producto pertenece a una categoría, se sale del ciclo
                    }
                }
            }
            echo "</div>";
        }
    } else {
        echo "<p>No hay productos disponibles</p>";
    }
    ?>

    <footer>
        <p>© <?php echo date("Y"); ?> Las D'licias. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
