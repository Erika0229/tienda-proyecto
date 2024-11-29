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

// Consultar las tablas de pagos y direcciones
$resultPagos = $conn->query("SELECT * FROM pagos");
$resultDirecciones = $conn->query("SELECT * FROM direcciones");

// Cerrar conexión después de hacer las consultas
// La conexión se cerrará en el archivo HTML

// Incluye el archivo HTML para mostrar los datos
include 'gestion_pagos.html';
?>
