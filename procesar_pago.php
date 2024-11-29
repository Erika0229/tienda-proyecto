<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "direccion_pago";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$codigo_postal = $_POST['codigo_postal'];
$nombre_tarjeta = $_POST['nombre_tarjeta'];
$numero_tarjeta = $_POST['numero_tarjeta'];
$mes_vencimiento = $_POST['mes_vencimiento'];
$anio_vencimiento = $_POST['anio_vencimiento'];
$cvv = $_POST['cvv'];

// Usar sentencias preparadas para evitar inyecciones SQL
$stmt = $conn->prepare("INSERT INTO pagos (nombre_completo, correo, direccion, ciudad, codigo_postal, nombre_tarjeta, numero_tarjeta, mes_vencimiento, anio_vencimiento, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $nombre_completo, $correo, $direccion, $ciudad, $codigo_postal, $nombre_tarjeta, $numero_tarjeta, $mes_vencimiento, $anio_vencimiento, $cvv);


if ($stmt->execute()) {
    echo "Pago procesado correctamente";
    echo '<br>'; // Espacio entre el mensaje y el botón
    echo '<a href="https://maps.app.goo.gl/FKnkDmRVRBCm4ztX8" style="display:inline-block; padding:10px 20px; color:white; background-color:green; text-decoration:none; border-radius:5px;">Rastrear Pedido</a>';
} else {
    echo "Error: " . $stmt->error;
}



// Cerrar conexión
$stmt->close();
$conn->close();
?>
