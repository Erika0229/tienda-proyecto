<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$base_de_datos = "tienda";

$conn = new mysqli($servidor, $usuario, $contraseña, $base_de_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>