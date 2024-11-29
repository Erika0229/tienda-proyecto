<?php
// Conexión a la base de datos
$servername = "localhost"; // Cambia esto si es necesario
$username = "root"; // Cambia esto por tu usuario
$password = ""; // Cambia esto por tu contraseña
$dbname = "tienda"; // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del pedido
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consultar para obtener el pedido específico
$sql = "SELECT * FROM pedidos WHERE id = $id";
$result = $conn->query($sql);
$pedido = $result->fetch_assoc();

// Si no se encuentra el pedido, redirigir o mostrar un error
if (!$pedido) {
    die("Pedido no encontrado.");
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $codigo_postal = $_POST['codigo_postal'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $total = $_POST['total'];
    $metodo_pago = $_POST['metodo_pago'];

    // Actualizar el pedido en la base de datos
    $update_sql = "UPDATE pedidos SET 
        nombre_completo = '$nombre_completo',
        correo = '$correo',
        direccion = '$direccion',
        ciudad = '$ciudad',
        codigo_postal = '$codigo_postal',
        producto_id = '$producto_id',
        cantidad = '$cantidad',
        total = '$total',
        metodo_pago = '$metodo_pago' 
        WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Pedido actualizado con éxito.";
        header("Location: panel_administrador.php"); // Redirigir después de la actualización
        exit();
    } else {
        echo "Error al actualizar el pedido: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Editar Pedido</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ffffff; /* Fondo blanco para la página */
        }

        /* Estilos para la barra de navegación */
        .navbar {
            background-color: #003366; /* Azul oscuro */
        }
        .navbar a {
            color: white !important;
            font-size: 18px;
            padding: 15px 20px;
        }
        .navbar a:hover {
            background-color: #00509e; /* Azul más brillante al pasar el mouse */
        }

        .container {
            margin-top: 50px;
            border: 1px solid #ced4da;
            border-radius: 10px;
            background-color: #f0f0f0; /* Fondo claro para el formulario */
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 30px;
            color: #003366; /* Color del título */
        }

        .btn-back {
            background-color: #28a745; /* Verde para el botón de volver */
            color: white;
        }

        .btn-primary {
            background-color: #00509e; /* Azul para el botón principal */
            border-color: #00509e;
        }

        .btn-primary:hover {
            background-color: #003366; /* Azul oscuro al pasar el mouse */
            border-color: #003366;
        }

        .btn-back:hover {
            background-color: #218838; /* Verde más oscuro al pasar el mouse */
        }

        footer {
            background-color: #003366; /* Azul oscuro */
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Barra de navegación con color azul oscuro -->
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#"> </a> <!-- Barra vacía -->
</nav>

<div class="container">
    <h2>Editar Pedido</h2>
    <form method="post">
        <div class="form-group">
            <label for="nombre_completo">Nombre Completo</label>
            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo $pedido['nombre_completo']; ?>" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $pedido['correo']; ?>" required>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $pedido['direccion']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ciudad">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?php echo $pedido['ciudad']; ?>" required>
        </div>
        <div class="form-group">
            <label for="codigo_postal">Código Postal</label>
            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="<?php echo $pedido['codigo_postal']; ?>" required>
        </div>
        <div class="form-group">
            <label for="producto_id">Producto ID</label>
            <input type="number" class="form-control" id="producto_id" name="producto_id" value="<?php echo $pedido['producto_id']; ?>" required>
        </div>
       
        <div class="form-group">
            <label for="total">Total</label>
            <input type="text" class="form-control" id="total" name="total" value="<?php echo $pedido['total']; ?>" required>
        </div>
        <div class="form-group">
            <label for="metodo_pago">Método de Pago</label>
            <input type="text" class="form-control" id="metodo_pago" name="metodo_pago" value="<?php echo $pedido['metodo_pago']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
        <a href="panel_administrador.php" class="btn btn-back">Cancelar</a>
    </form>
</div>

<!-- Pie de página -->
<footer>
    <p>&copy; 2024 Mi Tienda | Todos los derechos reservados.</p>
</footer>

</body>
</html>

