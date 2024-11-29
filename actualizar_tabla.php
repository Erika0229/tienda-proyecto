<?php
$conexion = new mysqli('localhost', 'root', '', 'direccion_pago');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$query = "SELECT * FROM pedidos ORDER BY fecha DESC";
$resultado = $conexion->query($query);

// Verificar si la consulta fue exitosa
if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $fila['id'] . "</td>";
        echo "<td>" . $fila['nombre_cliente'] . "</td>";
        echo "<td>" . $fila['detalles_pedido'] . "</td>";
        echo "<td>" . $fila['total'] . "</td>";
        echo "<td>" . $fila['fecha'] . "</td>";
        echo "<td>" . $fila['estado_pedido'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "Error al cargar los datos.";
}

$conexion->close();
?>

