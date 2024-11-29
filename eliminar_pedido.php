<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php'; // Asegúrate de que la ruta del archivo sea correcta

// Verifica si se ha recibido un ID en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pedido_id = $_GET['id'];

    // Prepara la consulta para eliminar el pedido
    $sql = "DELETE FROM pedidos WHERE id = ?";

    // Prepara la consulta
    if ($stmt = $conn->prepare($sql)) {
        // Enlaza el parámetro
        $stmt->bind_param("i", $pedido_id);

      // Ejecuta la consulta
if ($stmt->execute()) {
    // Si la eliminación fue exitosa, guarda el mensaje en la sesión
    $_SESSION['mensaje'] = "Pedido eliminado con éxito";
} else {
    // Si hay un error al eliminar, guarda el mensaje de error en la sesión
    $_SESSION['mensaje'] = "Error al eliminar el pedido: " . $conexion->error;
}

// Cierra la declaración
$stmt->close();

// Cierra la conexión a la base de datos
$conn->close();

// Redirige de vuelta a la página de gestión de pedidos
header("Location: gestion_pedidos.php");
exit;


          // Ejecuta la consulta
          if ($stmt->execute()) {
            // Si la eliminación fue exitosa, guarda el mensaje en la sesión
            $_SESSION['mensaje'] = "Pedido eliminado con éxito";
        } else {
            // Si hay error al eliminar, guarda el mensaje de error en la sesión
            $_SESSION['mensaje'] = "Error al eliminar el pedido: " . $conexion->error;
        }
        
        if ($stmt->execute()) {
            $mensaje = "Usuario registrado exitosamente.";
        } 
        
        else {
            echo "Error al eliminar el pedido: " . $conexion->error;
        }
        
        // Cierra la declaración
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }

    // Cierra la conexión a la base de datos
    $conexion->close();
} else {
    echo "ID de pedido no válido.";
}
?>
