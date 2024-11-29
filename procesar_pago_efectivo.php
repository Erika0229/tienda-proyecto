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

// Usar sentencias preparadas para evitar inyecciones SQL
$stmt = $conn->prepare("INSERT INTO direcciones (nombre_completo, correo, direccion, ciudad, codigo_postal) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nombre_completo, $correo, $direccion, $ciudad, $codigo_postal);

if ($stmt->execute()) {
    echo "Direccion guardada correctamente";
    echo '<br>'; // Espacio entre el mensaje y el botón
    echo '<a href="https://maps.app.goo.gl/FKnkDmRVRBCm4ztX8" style="display:inline-block; padding:10px 20px; color:white; background-color:green; text-decoration:none; border-radius:5px;">Rastrear Pedido</a>';
} else {
    echo "Error: " . $stmt->error;
}


// Cerrar conexión
$stmt->close();
$conn->close();
?>

