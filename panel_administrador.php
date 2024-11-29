<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin') {
    // Cargar el contenido del archivo HTML
    $html = file_get_contents('panel_administrador.html');

    // Reemplazar el marcador del nombre del usuario en el HTML
    $html = str_replace('<!-- Aquí irá el nombre del usuario -->', $_SESSION['nombre_user'], $html);

    // Mostrar el HTML
    echo $html;
} else {
    // Redirigir si no es administrador
    header('Location: tienda.php');
    exit;
}
?>

