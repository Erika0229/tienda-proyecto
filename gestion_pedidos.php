

<?php
// Conexión a la base de datos
$servername = "localhost"; // Cambia esto si es necesario
$username = "root"; // Cambia esto por tu usuario
$password = ""; // Cambia esto por tu contraseña
$dbname = "tienda"; // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


// Consultar para obtener los pedidos
$sql = "SELECT * FROM pedidos";
$result = $conn->query($sql);

$pedidos = []; // Inicializar un array para los pedidos
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $pedidos[] = $row; // Almacenar cada fila en el array
    }
}




include 'gestion_pedidos.html';
// Cerrar la conexión
$conn->close();
?>
