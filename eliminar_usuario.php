<?php
session_start();

// Verificar si el usuario es administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    // Conexión a la base de datos
    require 'conexion.php';

    // Verificar que se haya enviado el ID del usuario a eliminar
    if (isset($_POST['id_user'])) {
        $id_user = $_POST['id_user'];

        // Preparar la consulta de eliminación de manera segura
        $sql = "DELETE FROM usuarios WHERE id_user = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id_user);
            if ($stmt->execute()) {
                // Redirigir a la página de gestión de usuarios con un mensaje de éxito
                header("Location: gestion_usuarios.php?mensaje=Usuario eliminado exitosamente");
            } else {
                // Redirigir con un mensaje de error
                header("Location: gestion_usuarios.php?mensaje=Error al eliminar el usuario");
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }
    } else {
        // Redirigir si no se proporcionó un ID de usuario
        header("Location: gestion_usuarios.php?mensaje=ID de usuario no proporcionado");
    }

    $conn->close();
} else {
    // Redirigir si no es administrador
    header('Location: tienda.php');
    exit();
}
?>
