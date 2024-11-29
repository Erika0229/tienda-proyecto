<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión solo si no está activa
}  
include 'header.php'; // Incluye el encabezado

ob_start();
include('conexion.php');
include('encabezado.php');

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

// Procesar adición de producto al carrito (sin cantidad, solo un producto por vez)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $producto_id = $_POST['producto_id'];
    
    // Consulta para obtener el precio del producto
    $sql = "SELECT precio FROM productos WHERE id = $producto_id";
    $result = $conn->query($sql);
    $producto = $result->fetch_assoc();
    
    // Total será solo el precio del producto, ya no se usa cantidad
    $total = $producto['precio'];

    // Insertamos solo el producto sin considerar cantidad
    $sql = "INSERT INTO carrito (producto_id, total) VALUES ($producto_id, $total)";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: tienda.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Procesar el pedido
if (isset($_POST['realizar_pedido'])) {
    // Recoger datos del formulario
    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $codigo_postal = $_POST['codigo_postal'];
    $metodo_pago = $_POST['metodo_pago']; // Capturando el método de pago
    $fecha = date('Y-m-d H:i:s'); // Captura la fecha actual

    // Consulta para obtener los productos del carrito
    $carrito_sql = "SELECT * FROM carrito";
    $carrito_result = $conn->query($carrito_sql);

    if ($carrito_result->num_rows > 0) {
        // Preparar la consulta para insertar en la tabla de pedidos
        $pedido_sql = "INSERT INTO pedidos (nombre_completo, correo, direccion, ciudad, codigo_postal, producto_id, total, metodo_pago, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($pedido_sql);
        
        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            echo "Error al preparar la consulta: " . $conn->error;
            exit();
        }

        // Ejecutar la inserción por cada producto en el carrito
        while ($row = $carrito_result->fetch_assoc()) {
            $producto_id = $row['producto_id'];
            $total = $row['total'];

            // Vincular los parámetros
            $stmt->bind_param("sssssiiss", $nombre_completo, $correo, $direccion, $ciudad, $codigo_postal, $producto_id, $total, $metodo_pago, $fecha);

            // Ejecutar la consulta
            if (!$stmt->execute()) {
                echo "Error al realizar el pedido: " . $stmt->error;
            }
        }

        // Limpiar el carrito después de realizar el pedido
        $conn->query("DELETE FROM carrito");
        echo "Pedido realizado exitosamente.";

        // Redirigir a la página del método de pago
        if ($metodo_pago === 'Tarjeta') {
            header("Location: pago.html");
        } elseif ($metodo_pago === 'Efectivo') {
            header("Location: direccionEnv.html");
        } elseif ($metodo_pago === 'PayPal') { 
            header("Location: https://www.paypal.com/co/digital-wallet/send-receive-money/paypal-me");
        }
        exit();
    } else {
        echo "El carrito está vacío. No se puede realizar el pedido.";
    }
}

?>

<script>
// Función para calcular el total final (ahora no se considera la cantidad)
function actualizarTotalFinal() {
    var totalFinal = 0;
    var totalElements = document.querySelectorAll('[id^="total_"]');
    totalElements.forEach(function(element) {
        var total = parseFloat(element.innerText.replace("Total: $", ""));
        totalFinal += total || 0; // Sumar el total si no es NaN
    });
    document.getElementById("totalFinal").innerText = "Total Final: $" + totalFinal.toFixed(2);
}
</script>

<style>
    .producto {
        text-align: center;
        margin: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 15px;
        background-color: #f9f9f9;
        width: 220px; /* Ancho fijo para todos los productos */
    }
    .producto img {
        width: 150px; /* Ancho fijo */
        height: 150px; /* Alto fijo */
        object-fit: cover; /* Recortar imagen para que llene el espacio */
    }
    .productos-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    /* Estilo para el total final */
    #totalFinal {
        margin: 20px auto;
        padding: 20px;
        background-color: #f0f8ff;
        border: 1px solid #007BFF;
        border-radius: 10px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: #0056b3;
        width: 80%; /* Ajusta el ancho */
        max-width: 400px; /* Máximo tamaño del contenedor */
    }
</style>

<?php
// Mostrar productos en el carrito (solo muestra el precio, no el total)
$totalFinal = 0; // Inicializamos la variable para el total final
$sql = "SELECT carrito.id, productos.nombre, productos.imagen, carrito.total, productos.precio
        FROM carrito
        JOIN productos ON carrito.producto_id = productos.id";
$result = $conn->query($sql);

echo '<div class="productos-container">';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='producto'>";
        echo "<h2 style='font-weight: bold; text-transform: uppercase;'>" . htmlspecialchars($row['nombre']) . "</h2>";
        echo "<img src='" . htmlspecialchars($row['imagen']) . "' alt='" . htmlspecialchars($row['nombre']) . "'>";
        
        // Solo mostramos el precio y no el total
        echo "<p style='font-weight: bold; text-transform: uppercase;'>Precio: $" . htmlspecialchars($row['precio']) . "</p>";
        
        // Sumar el total al totalFinal (manteniendo el cálculo correcto)
        $totalFinal += $row['total'];

        // Formulario para eliminar el producto del carrito
        echo "<form action='carrito.php' method='POST' style='display:inline;'>";
        echo "<input type='hidden' name='carrito_id' value='" . htmlspecialchars($row['id']) . "'>";
        echo "<input type='submit' name='delete' value='Eliminar' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este producto del carrito?\");'>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "El carrito está vacío.";
}
echo '</div>';

// Mostrar el total final del carrito
echo "<p id='totalFinal'>Total Final: $" . number_format($totalFinal, 2) . "</p>";
?>

<!-- Formulario para realizar el pedido -->
<form method="POST" action="" style="margin: 20px; padding: 20px; border: 1px solid #007BFF; border-radius: 10px; background-color: #f0f8ff;">
    <input type="hidden" name="realizar_pedido" value="1">
    
    <h2 style="text-align: center; font-family: 'Arial', sans-serif; font-weight: bold; color: #007BFF;">Realizar Pedido</h2>

    <label for="metodo_pago" style="font-weight: bold; font-style: italic; font-size: 18px; color: #0056b3;">Selecciona un método de pago:</label>
    <select id="metodo_pago" name="metodo_pago" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; background-color: #e6f9e6; cursor: pointer; font-size: 16px; width: 100%; margin-bottom: 15px;">
        <option value="" disabled selected>Selecciona un método</option>
        <option value="Tarjeta">Tarjeta débito o crédito</option>
        <option value="Efectivo">Efectivo</option>
        <option value="PayPal">PayPal</option>
    </select>

    <label for="nombre_completo" style="font-weight: dbold; font-style: italic; font-size: 18px; color: #0056b3;">Nombre Completo:</label>
    <input type="text" name="nombre_completo" required style="padding: 10px; margin: 5px 0; width: 100%; border-radius: 4px; border: 1px solid #ccc; font-size: 16px;">

    <label for="correo" style="font-weight: bold; font-style: italic; font-size: 18px; color: #0056b3;">Correo:</label>
    <input type="email" name="correo" required style="padding: 10px; margin: 5px 0; width: 100%; border-radius: 4px; border: 1px solid #ccc; font-size: 16px;">

    <label for="direccion" style="font-weight: bold; font-style: italic; font-size: 18px; color: #0056b3;">Dirección:</label>
    <input type="text" name="direccion" required style="padding: 10px; margin: 5px 0; width: 100%; border-radius: 4px; border: 1px solid #ccc; font-size: 16px;">

    <label for="ciudad" style="font-weight: bold; font-style: italic; font-size: 18px; color: #0056b3;">Ciudad:</label>
    <input type="text" name="ciudad" required style="padding: 10px; margin: 5px 0; width: 100%; border-radius: 4px; border: 1px solid #ccc; font-size: 16px;">

    <label for="codigo_postal" style="font-weight: bold; font-style: italic; font-size: 18px; color: #0056b3;">Código Postal:</label>
    <input type="text" name="codigo_postal" required style="padding: 10px; margin: 5px 0; width: 100%; border-radius: 4px; border: 1px solid #ccc; font-size: 16px;">

    <button type="submit" style="padding: 10px 20px; margin-top: 15px; background-color: #007BFF; color: white; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; transition: background-color 0.3s;">
        Realizar Pedido
    </button>
</form>

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

<?php
ob_end_flush();
?>
