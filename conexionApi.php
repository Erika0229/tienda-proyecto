<?php
// conexionApi.php


// Datos de conexión a la base de datos
$host = 'localhost';
$dbname = 'tutorioz';
$username = 'root';
$password = '';

// Intentar establecer la conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Opcional: configurar el juego de caracteres
    $pdo->exec("set names utf8");
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

function obtenerRegistros() {
    global $pdo;
    try {
        $query = "SELECT * FROM usuarios"; // Asegúrate de reemplazar 'usuarios' con el nombre correcto de tu tabla
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Capturar cualquier excepción PDO que pueda ocurrir
        die("Error al obtener registros: " . $e->getMessage());
    }
}


// Otras funciones para insertar, actualizar, eliminar, etc.
// Ejemplo de función para insertar un nuevo registro
function insertarRegistro($datos) {
    global $pdo;
    $query = "INSERT INTO usuarios (id_user, nombre_usre, contraseña_user, correo_user) VALUES (:id_user, nombre_user, contraseña_user, correo_user)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_user, nombre_user, contraseña_user, correo_user', $datos['id_user, nombre_user, contraseña_user, correo_user']);
    $stmt->bindParam(':id_user, nombre_user, contraseña_user, correo_user', $datos['id_user, nombre_user, contraseña_user, correo_user']);
    return $stmt->execute();
}

// Puedes añadir más funciones según tus necesidades
?>
