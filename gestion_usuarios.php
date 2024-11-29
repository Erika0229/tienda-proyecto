<?php
// Iniciar la sesión para verificar si el usuario es administrador
session_start();

// Verificar si el usuario ha iniciado sesión y es administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    if (isset($_GET['mensaje'])) {
        echo "<div class='alert alert-info' id='mensaje-alert'>" . htmlspecialchars($_GET['mensaje']) . "</div>";
    }
    
    // Cargar el contenido del archivo HTML
    $html = file_get_contents('gestion_usuarios.html');

    // Conexión a la base de datos
    require 'conexion.php';
    // Mostrar mensajes si existen
     
    // Consultar los datos de los usuarios
    $sql = "SELECT id_user, nombre_user, correo_user, rol FROM usuarios";
    $resultado = $conn->query($sql);

    // Preparar el contenido de la tabla
    $tablaUsuarios = '';
    if ($resultado === false) {
        $tablaUsuarios = "<p>Error en la consulta: " . $conn->error . "</p>";
    } else {
        if ($resultado->num_rows > 0) {
            $tablaUsuarios .= "<h2>Gestión de Usuarios</h2>";
            $tablaUsuarios .= "<table class='table table-striped'>";
            $tablaUsuarios .= "<thead><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th><th>Acciones</th></tr></thead>";
            $tablaUsuarios .= "<tbody>";

            // Recorrer los resultados y construir las filas de la tabla
            while ($fila = $resultado->fetch_assoc()) {
                $tablaUsuarios .= "<tr>";
                $tablaUsuarios .= "<td>" . htmlspecialchars($fila['id_user']) . "</td>";
                $tablaUsuarios .= "<td>" . htmlspecialchars($fila['nombre_user']) . "</td>";
                $tablaUsuarios .= "<td>" . htmlspecialchars($fila['correo_user']) . "</td>";
                $tablaUsuarios .= "<td>" . htmlspecialchars($fila['rol']) . "</td>";
                $tablaUsuarios .= "<td>";
                
                // Botón de eliminar
                $tablaUsuarios .= "<form action='eliminar_usuario.php' method='POST' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar este usuario?\");' style='display:inline;'>"; // Asegúrate de que el formulario esté en línea
                $tablaUsuarios .= "<input type='hidden' name='id_user' value='" . htmlspecialchars($fila['id_user']) . "'>";
                $tablaUsuarios .= "<button type='submit' class='btn btn-danger'>Eliminar</button>";
                $tablaUsuarios .= "</form>";
                
                // Botón de editar
                $tablaUsuarios .= "<a href='editar_usuario.php?id=" . htmlspecialchars($fila['id_user']) . "' class='btn btn-primary' style='margin-left: 5px;'>Editar</a>"; // Agrega margen izquierdo para separación
                
                $tablaUsuarios .= "</td>"; // Cierra la celda
                $tablaUsuarios .= "</tr>";
            }
            

            $tablaUsuarios .= "</tbody></table>";
        } else {
            $tablaUsuarios = "<p>No hay usuarios registrados.</p>";
        }
    }

    $conn->close();

    // Reemplazar el el HTML por la tabla de usuarios 
    $html = str_replace("{{tabla_usuarios}}", $tablaUsuarios, $html);

    // Mostrar el HTML r
    echo $html;

} else {
    // Redirigir si no es administrador
    header('Location: tienda.php');
    exit(); // Asegúrate de salir después de redirigir
}
?>
<script>
// Función para ocultar el mensaje después de 3 segundos (3000 ms)
setTimeout(function() {
    var mensajeAlert = document.getElementById('mensaje-alert');
    if (mensajeAlert) {
        mensajeAlert.style.display = 'none';
    }
}, 3000); 
</script>
