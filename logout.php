<?php
session_start(); // Inicia la sesión

// Destruye todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, se debe borrar también la cookie de sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruye la sesión
session_destroy();

// Redirige a la página deseada
header("Location: catalogo.html"); // Cambia a catalogo.html
exit();
?>

