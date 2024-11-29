<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'direccion_pago');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener los pedidos
$query = "SELECT * FROM pedidos ORDER BY fecha DESC";
$resultado = $conexion->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Administrador</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Pedidos en Tiempo Real</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Detalles</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody id="tablaPedidos">
            <!-- Aquí se actualizará el contenido -->
        </tbody>
    </table>

    <script>
        function actualizarTabla() {
            $.ajax({
                url: 'actualizar_tabla.php',
                method: 'GET',
                success: function(data) {
                    $('#tablaPedidos').html(data);
                }
            });
        }

        // Actualizar la tabla cada 5 segundos
        setInterval(actualizarTabla, 5000);

        // Llamar a la función por primera vez
        actualizarTabla();
    </script>
</body>
</html>
