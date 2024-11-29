<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    require 'conexion.php'; // Conexión a la base de datos

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtener los datos del formulario
        $id_user = $_POST['id_user'];
        $nombre_user = $_POST['nombre_user'];
        $correo_user = $_POST['correo_user'];
        $rol = $_POST['rol'];

        // Actualizar los datos del usuario
        $sql = "UPDATE usuarios SET nombre_user = ?, correo_user = ?, rol = ? WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre_user, $correo_user, $rol, $id_user);

        if ($stmt->execute()) {
            // Redirigir a la gestión de usuarios con un mensaje de éxito
            header('Location: gestion_usuarios.php?mensaje=Usuario actualizado correctamente');
            exit();
        } else {
            echo "Error al actualizar el usuario: " . $stmt->error;
        }
    }
    $conn->close();
} else {
    header('Location: tienda.php');
    exit();
}
?>
