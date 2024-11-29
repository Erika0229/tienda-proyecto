<?php
session_start();
session_destroy(); // Destruye la sesión
header("Location: catalogo.html"); // Redirige a la página principal
exit();
?>
